<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * MenuGroup model (Phase 8.1)
 * 
 * Groups organize menu items by position (sidebar, topbar, footer)
 * Tenant-aware
 */
class MenuGroup extends Model
{
    protected $fillable = [
        'tenant_id',
        'name',
        'slug',
        'position',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Items in this group
     */
    public function items(): HasMany
    {
        return $this->hasMany(MenuItem::class)->orderBy('sort_order');
    }

    /**
     * Only top-level items (no parent)
     */
    public function rootItems(): HasMany
    {
        return $this->hasMany(MenuItem::class)
            ->whereNull('parent_id')
            ->orderBy('sort_order');
    }

    /**
     * Scope: by tenant
     */
    public function scopeForTenant($query, ?int $tenantId = null)
    {
        return $query->where('tenant_id', $tenantId ?? tenant_id());
    }

    /**
     * Scope: by position
     */
    public function scopeByPosition($query, string $position)
    {
        return $query->where('position', $position);
    }

    /**
     * Scope: active only
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
