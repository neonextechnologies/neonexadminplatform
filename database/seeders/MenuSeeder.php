<?php

namespace Database\Seeders;

use App\Models\MenuGroup;
use App\Models\MenuItem;
use Illuminate\Database\Seeder;

/**
 * MenuSeeder (Phase 8)
 * 
 * Seeds default sidebar menu for the default tenant
 * Items match the existing admin features (Phase 0-7)
 */
class MenuSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('🗂️ Seeding default menus...');

        $tenantId = 1; // Default tenant

        // Create sidebar menu group
        $sidebarGroup = MenuGroup::firstOrCreate(
            ['tenant_id' => $tenantId, 'slug' => 'main-sidebar'],
            [
                'name' => 'Main Sidebar',
                'position' => 'sidebar',
                'sort_order' => 0,
                'is_active' => true,
            ]
        );

        $this->command->info("  ✓ Group: {$sidebarGroup->name}");

        // Seed sidebar items
        $items = [
            // Main section header
            ['title' => 'Main', 'type' => 'divider', 'icon' => '', 'sort_order' => 0],
            // Dashboard
            ['title' => 'Dashboard', 'type' => 'route', 'route_name' => 'dashboard', 'icon' => 'ph-squares-four', 'sort_order' => 1],
            // Users (permission: users.view)
            ['title' => 'Users', 'type' => 'route', 'route_name' => 'users.index', 'icon' => 'ph-users', 'permission' => 'users.view', 'sort_order' => 2],

            // Products section header
            ['title' => 'Content', 'type' => 'divider', 'icon' => '', 'sort_order' => 10],
            // Products (permission: product.view)
            ['title' => 'Products', 'type' => 'route', 'route_name' => 'admin.product.index', 'icon' => 'ph-package', 'permission' => 'product.view', 'sort_order' => 11],

            // Administration section header
            ['title' => 'Administration', 'type' => 'divider', 'icon' => '', 'sort_order' => 90],
            // Menu Builder (permission: menu.view)
            ['title' => 'Menu Builder', 'type' => 'route', 'route_name' => 'admin.menu.index', 'icon' => 'ph-list-numbers', 'permission' => 'menu.view', 'sort_order' => 91],
        ];

        foreach ($items as $itemData) {
            $item = MenuItem::firstOrCreate(
                [
                    'tenant_id' => $tenantId,
                    'menu_group_id' => $sidebarGroup->id,
                    'title' => $itemData['title'],
                ],
                array_merge($itemData, ['tenant_id' => $tenantId, 'menu_group_id' => $sidebarGroup->id])
            );

            if ($item->wasRecentlyCreated) {
                $this->command->info("    ✓ Item: {$item->title}");
                audit()->record('menu.item.seeded', $item);
            }
        }

        $this->command->info('✅ Menus seeded successfully');
    }
}
