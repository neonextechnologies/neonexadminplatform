<?php

namespace App\Services;

use App\Contracts\Menu\MenuServiceContract;
use App\Models\MenuGroup;
use App\Models\MenuItem;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

/**
 * MenuService (Phase 8.1)
 * 
 * Manages menu groups and items with:
 * - Tenant-aware queries
 * - Cache-first pattern with invalidation
 * - Audit-first operations
 * - Nested tree building
 */
class MenuService implements MenuServiceContract
{
    /**
     * Cache TTL in seconds (10 minutes)
     */
    protected int $cacheTtl = 600;

    /**
     * Get menu tree for a position
     * Cache-first: reads from cache, falls back to DB
     */
    public function getTree(string $position = 'sidebar', ?int $tenantId = null): array
    {
        $tenantId = $tenantId ?? tenant_id();
        $cacheKey = "menu_tree:{$tenantId}:{$position}";

        return Cache::remember($cacheKey, $this->cacheTtl, function () use ($position, $tenantId) {
            return $this->buildTree($position, $tenantId);
        });
    }

    /**
     * Build menu tree from DB
     */
    protected function buildTree(string $position, int $tenantId): array
    {
        $groups = MenuGroup::where('tenant_id', $tenantId)
            ->where('position', $position)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->with(['rootItems' => function ($query) {
                $query->where('is_active', true)
                    ->orderBy('sort_order')
                    ->with(['children' => function ($q) {
                        $q->where('is_active', true)->orderBy('sort_order');
                    }]);
            }])
            ->get();

        $tree = [];
        foreach ($groups as $group) {
            foreach ($group->rootItems as $item) {
                $tree[] = $item->toTreeArray();
            }
        }

        return $tree;
    }

    /**
     * Get flat list of items for a group
     */
    public function getGroupItems(int $groupId): Collection
    {
        return MenuItem::where('menu_group_id', $groupId)
            ->forTenant()
            ->orderBy('parent_id')
            ->orderBy('sort_order')
            ->get();
    }

    /**
     * Create menu group with audit
     */
    public function createGroup(array $data): MenuGroup
    {
        $data['tenant_id'] = $data['tenant_id'] ?? tenant_id();

        $group = MenuGroup::create($data);

        audit()->record('menu.group.created', $group);
        $this->clearCache($data['tenant_id']);

        return $group;
    }

    /**
     * Update menu group with audit
     */
    public function updateGroup(MenuGroup $group, array $data): MenuGroup
    {
        $group->update($data);

        audit()->record('menu.group.updated', $group);
        $this->clearCache($group->tenant_id);

        return $group;
    }

    /**
     * Delete menu group with audit
     */
    public function deleteGroup(MenuGroup $group): void
    {
        $tenantId = $group->tenant_id;
        
        audit()->record('menu.group.deleted', $group);
        
        $group->delete();
        $this->clearCache($tenantId);
    }

    /**
     * Create menu item with audit
     */
    public function createItem(array $data): MenuItem
    {
        $data['tenant_id'] = $data['tenant_id'] ?? tenant_id();

        // Auto-set sort_order to last position
        if (!isset($data['sort_order'])) {
            $data['sort_order'] = MenuItem::where('menu_group_id', $data['menu_group_id'])
                ->where('parent_id', $data['parent_id'] ?? null)
                ->max('sort_order') + 1;
        }

        $item = MenuItem::create($data);

        audit()->record('menu.item.created', $item);
        $this->clearCache($data['tenant_id']);

        return $item;
    }

    /**
     * Update menu item with audit
     */
    public function updateItem(MenuItem $item, array $data): MenuItem
    {
        $item->update($data);

        audit()->record('menu.item.updated', $item);
        $this->clearCache($item->tenant_id);

        return $item;
    }

    /**
     * Delete menu item with audit
     */
    public function deleteItem(MenuItem $item): void
    {
        $tenantId = $item->tenant_id;
        
        audit()->record('menu.item.deleted', $item);
        
        $item->delete();
        $this->clearCache($tenantId);
    }

    /**
     * Reorder items by array of IDs
     */
    public function reorderItems(array $orderedIds): void
    {
        foreach ($orderedIds as $order => $id) {
            MenuItem::where('id', $id)
                ->forTenant()
                ->update(['sort_order' => $order]);
        }

        $this->clearCache();
    }

    /**
     * Move item up (decrease sort_order)
     */
    public function moveUp(MenuItem $item): void
    {
        $sibling = MenuItem::where('menu_group_id', $item->menu_group_id)
            ->where('parent_id', $item->parent_id)
            ->where('sort_order', '<', $item->sort_order)
            ->where('tenant_id', $item->tenant_id)
            ->orderByDesc('sort_order')
            ->first();

        if ($sibling) {
            $tempOrder = $item->sort_order;
            $item->update(['sort_order' => $sibling->sort_order]);
            $sibling->update(['sort_order' => $tempOrder]);
            $this->clearCache($item->tenant_id);
        }
    }

    /**
     * Move item down (increase sort_order)
     */
    public function moveDown(MenuItem $item): void
    {
        $sibling = MenuItem::where('menu_group_id', $item->menu_group_id)
            ->where('parent_id', $item->parent_id)
            ->where('sort_order', '>', $item->sort_order)
            ->where('tenant_id', $item->tenant_id)
            ->orderBy('sort_order')
            ->first();

        if ($sibling) {
            $tempOrder = $item->sort_order;
            $item->update(['sort_order' => $sibling->sort_order]);
            $sibling->update(['sort_order' => $tempOrder]);
            $this->clearCache($item->tenant_id);
        }
    }

    /**
     * Clear menu cache for tenant
     */
    public function clearCache(?int $tenantId = null): void
    {
        $tenantId = $tenantId ?? tenant_id();
        
        foreach (['sidebar', 'topbar', 'footer'] as $position) {
            Cache::forget("menu_tree:{$tenantId}:{$position}");
        }
    }
}
