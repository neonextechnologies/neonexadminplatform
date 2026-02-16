<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * MenuItem model (Phase 8.1)
 * 
 * Individual menu item with nested support
 * Types: route, url, divider
 * Permission-based visibility
 */
class MenuItem extends Model
{
    protected $fillable = [
        'tenant_id',
        'menu_group_id',
        'parent_id',
        'title',
        'type',
        'url',
        'route_name',
        'icon',
        'permission',
        'sort_order',
        'is_active',
        'meta',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
        'meta' => 'array',
    ];

    /**
     * Parent item (for nested menus)
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(MenuItem::class, 'parent_id');
    }

    /**
     * Child items
     */
    public function children(): HasMany
    {
        return $this->hasMany(MenuItem::class, 'parent_id')->orderBy('sort_order');
    }

    /**
     * Menu group this item belongs to
     */
    public function group(): BelongsTo
    {
        return $this->belongsTo(MenuGroup::class, 'menu_group_id');
    }

    /**
     * Scope: by tenant
     */
    public function scopeForTenant($query, ?int $tenantId = null)
    {
        return $query->where('tenant_id', $tenantId ?? tenant_id());
    }

    /**
     * Scope: root items only
     */
    public function scopeRoots($query)
    {
        return $query->whereNull('parent_id');
    }

    /**
     * Scope: active only
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Check if this item has children
     */
    public function hasChildren(): bool
    {
        return $this->children()->active()->exists();
    }

    /**
     * Convert to tree-compatible array
     */
    public function toTreeArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'type' => $this->type,
            'url' => $this->url,
            'route_name' => $this->route_name,
            'icon' => $this->icon,
            'permission' => $this->permission,
            'sort_order' => $this->sort_order,
            'meta' => $this->meta,
            'children' => $this->children->where('is_active', true)
                ->sortBy('sort_order')
                ->map(fn ($child) => $child->toTreeArray())
                ->values()
                ->toArray(),
        ];
    }
}
