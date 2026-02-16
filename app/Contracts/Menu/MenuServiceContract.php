<?php

namespace App\Contracts\Menu;

/**
 * MenuServiceContract (Phase 8.1)
 * 
 * Contract for menu service providing menu tree retrieval,
 * CRUD operations, reorder, and cache management.
 */
interface MenuServiceContract
{
    /**
     * Get menu tree for a position (sidebar, topbar, footer)
     * Returns nested array of items suitable for rendering
     */
    public function getTree(string $position = 'sidebar', ?int $tenantId = null): array;

    /**
     * Get flat list of items for a group
     */
    public function getGroupItems(int $groupId): \Illuminate\Database\Eloquent\Collection;

    /**
     * Create a menu group
     */
    public function createGroup(array $data): \App\Models\MenuGroup;

    /**
     * Update a menu group
     */
    public function updateGroup(\App\Models\MenuGroup $group, array $data): \App\Models\MenuGroup;

    /**
     * Delete a menu group
     */
    public function deleteGroup(\App\Models\MenuGroup $group): void;

    /**
     * Create a menu item
     */
    public function createItem(array $data): \App\Models\MenuItem;

    /**
     * Update a menu item
     */
    public function updateItem(\App\Models\MenuItem $item, array $data): \App\Models\MenuItem;

    /**
     * Delete a menu item
     */
    public function deleteItem(\App\Models\MenuItem $item): void;

    /**
     * Reorder items (update sort_order)
     */
    public function reorderItems(array $orderedIds): void;

    /**
     * Move item up in sort order
     */
    public function moveUp(\App\Models\MenuItem $item): void;

    /**
     * Move item down in sort order
     */
    public function moveDown(\App\Models\MenuItem $item): void;

    /**
     * Clear cached menus for current tenant
     */
    public function clearCache(?int $tenantId = null): void;
}
