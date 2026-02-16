<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\Menu\MenuServiceContract;
use App\Http\Controllers\Controller;
use App\Models\MenuGroup;
use App\Models\MenuItem;
use Illuminate\Http\Request;

/**
 * MenuController (Phase 8.3)
 * 
 * Admin menu builder - Blade SSR (no Inertia/Vue)
 * Manages menu groups and items
 * Tenant-safe + audit-first
 */
class MenuController extends Controller
{
    protected MenuServiceContract $menuService;

    public function __construct(MenuServiceContract $menuService)
    {
        $this->menuService = $menuService;
    }

    /**
     * Menu builder index - shows groups and items
     */
    public function index(Request $request)
    {
        $groups = MenuGroup::forTenant()
            ->orderBy('position')
            ->orderBy('sort_order')
            ->get();

        $activeGroup = null;
        $items = collect();

        if ($request->has('group') && $request->group) {
            $activeGroup = MenuGroup::forTenant()->find($request->group);
            if ($activeGroup) {
                $items = $this->menuService->getGroupItems($activeGroup->id);
            }
        } elseif ($groups->isNotEmpty()) {
            $activeGroup = $groups->first();
            $items = $this->menuService->getGroupItems($activeGroup->id);
        }

        return view('admin.menu.index', compact('groups', 'activeGroup', 'items'));
    }

    /**
     * Store a new menu group
     */
    public function storeGroup(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|alpha_dash',
            'position' => 'required|in:sidebar,topbar,footer',
        ]);

        $this->menuService->createGroup($validated);

        return redirect()->route('admin.menu.index')
            ->with('success', 'Menu group created.');
    }

    /**
     * Update a menu group
     */
    public function updateGroup(Request $request, MenuGroup $group)
    {
        abort_if($group->tenant_id !== tenant_id(), 403);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|in:sidebar,topbar,footer',
        ]);

        $this->menuService->updateGroup($group, $validated);

        return redirect()->route('admin.menu.index', ['group' => $group->id])
            ->with('success', 'Menu group updated.');
    }

    /**
     * Delete a menu group
     */
    public function destroyGroup(MenuGroup $group)
    {
        abort_if($group->tenant_id !== tenant_id(), 403);

        $this->menuService->deleteGroup($group);

        if (request()->expectsJson()) {
            return response()->json(['ok' => true, 'message' => 'Group deleted.']);
        }

        return redirect()->route('admin.menu.index')
            ->with('success', 'Menu group deleted.');
    }

    /**
     * Store a new menu item
     */
    public function storeItem(Request $request)
    {
        $validated = $request->validate([
            'menu_group_id' => 'required|exists:menu_groups,id',
            'parent_id' => 'nullable|exists:menu_items,id',
            'title' => 'required|string|max:255',
            'type' => 'required|in:route,url,divider',
            'url' => 'nullable|string|max:500',
            'route_name' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:255',
            'permission' => 'nullable|string|max:255',
        ]);

        $this->menuService->createItem($validated);

        return redirect()->route('admin.menu.index', ['group' => $validated['menu_group_id']])
            ->with('success', 'Menu item created.');
    }

    /**
     * Update a menu item
     */
    public function updateItem(Request $request, MenuItem $item)
    {
        abort_if($item->tenant_id !== tenant_id(), 403);

        $validated = $request->validate([
            'parent_id' => 'nullable|exists:menu_items,id',
            'title' => 'required|string|max:255',
            'type' => 'required|in:route,url,divider',
            'url' => 'nullable|string|max:500',
            'route_name' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:255',
            'permission' => 'nullable|string|max:255',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        $this->menuService->updateItem($item, $validated);

        return redirect()->route('admin.menu.index', ['group' => $item->menu_group_id])
            ->with('success', 'Menu item updated.');
    }

    /**
     * Delete a menu item
     */
    public function destroyItem(MenuItem $item)
    {
        abort_if($item->tenant_id !== tenant_id(), 403);

        $groupId = $item->menu_group_id;
        $this->menuService->deleteItem($item);

        if (request()->expectsJson()) {
            return response()->json(['ok' => true, 'message' => 'Item deleted.']);
        }

        return redirect()->route('admin.menu.index', ['group' => $groupId])
            ->with('success', 'Menu item deleted.');
    }

    /**
     * Move item up
     */
    public function moveUp(MenuItem $item)
    {
        abort_if($item->tenant_id !== tenant_id(), 403);

        $this->menuService->moveUp($item);

        return redirect()->route('admin.menu.index', ['group' => $item->menu_group_id])
            ->with('success', 'Item moved up.');
    }

    /**
     * Move item down
     */
    public function moveDown(MenuItem $item)
    {
        abort_if($item->tenant_id !== tenant_id(), 403);

        $this->menuService->moveDown($item);

        return redirect()->route('admin.menu.index', ['group' => $item->menu_group_id])
            ->with('success', 'Item moved down.');
    }

    /**
     * Clear menu cache
     */
    public function clearCache()
    {
        $this->menuService->clearCache();

        return redirect()->route('admin.menu.index')
            ->with('success', 'Menu cache cleared.');
    }
}
