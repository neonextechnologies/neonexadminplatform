<?php

namespace Tests\Feature;

use App\Http\Middleware\TenantMiddleware;
use App\Models\MenuGroup;
use App\Models\MenuItem;
use App\Models\Permission;
use App\Models\Role;
use App\Models\Tenant;
use App\Models\TenantDomain;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * MenuBuilder Feature Tests (Phase 8)
 *
 * Proves:
 * - Tenant isolation (menu items scoped per tenant)
 * - Registry-first RBAC (permission middleware enforced)
 * - Audit-first (CRUD operations audited)
 */
class MenuBuilderTest extends TestCase
{
    use RefreshDatabase;

    protected User $adminUser;
    protected User $unprivilegedUser;
    protected Tenant $tenant;
    protected Role $adminRole;

    protected function setUp(): void
    {
        parent::setUp();

        // Create tenant
        $this->tenant = Tenant::create([
            'name' => 'Test Tenant',
            'slug' => 'test-tenant',
            'is_active' => true,
        ]);

        // Create tenant domain (for completeness)
        TenantDomain::create([
            'tenant_id' => $this->tenant->id,
            'domain' => 'localhost',
        ]);

        // Set tenant context directly (simulates what TenantMiddleware does)
        app('tenant')->set($this->tenant->id);

        // Create permissions (registry-first pattern)
        $menuPerms = [];
        foreach (['menu.view', 'menu.create', 'menu.update', 'menu.delete'] as $perm) {
            $menuPerms[] = Permission::firstOrCreate(
                ['name' => $perm],
                ['group' => 'Menus', 'description' => $perm]
            );
        }

        // Create admin role with all menu permissions
        $this->adminRole = Role::create([
            'name' => 'test-admin',
            'label' => 'Test Admin',
        ]);
        foreach ($menuPerms as $perm) {
            $this->adminRole->givePermission($perm);
        }

        // Create admin user with permissions
        $this->adminUser = User::factory()->create(['tenant_id' => $this->tenant->id]);
        $this->adminUser->assignRole($this->adminRole);

        // Create unprivileged user (no menu permissions)
        $this->unprivilegedUser = User::factory()->create(['tenant_id' => $this->tenant->id]);
    }

    // ─── RBAC Tests (Rule 7) ─────────────────────────────

    public function test_unauthenticated_user_cannot_access_menu_builder(): void
    {
        $response = $this->withoutMiddleware(TenantMiddleware::class)
            ->get(route('admin.menu.index'));

        $response->assertRedirect(route('login'));
    }

    public function test_unprivileged_user_cannot_view_menu_builder(): void
    {
        $response = $this->actingAs($this->unprivilegedUser)
            ->withoutMiddleware(TenantMiddleware::class)
            ->get(route('admin.menu.index'));

        $response->assertStatus(403);
    }

    public function test_admin_user_can_view_menu_builder(): void
    {
        $response = $this->actingAs($this->adminUser)
            ->withoutMiddleware(TenantMiddleware::class)
            ->get(route('admin.menu.index'));

        $response->assertStatus(200);
    }

    public function test_unprivileged_user_cannot_create_menu_group(): void
    {
        $response = $this->actingAs($this->unprivilegedUser)
            ->withoutMiddleware(TenantMiddleware::class)
            ->post(route('admin.menu.groups.store'), [
                'name' => 'Sidebar',
                'slug' => 'sidebar',
                'position' => 'sidebar',
            ]);

        $response->assertStatus(403);
    }

    // ─── CRUD + Audit Tests (Rule 8) ────────────────────

    public function test_admin_can_create_menu_group(): void
    {
        $response = $this->actingAs($this->adminUser)
            ->withoutMiddleware(TenantMiddleware::class)
            ->post(route('admin.menu.groups.store'), [
                'name' => 'Main Sidebar',
                'slug' => 'main-sidebar',
                'position' => 'sidebar',
            ]);

        $response->assertRedirect(route('admin.menu.index'));

        $this->assertDatabaseHas('menu_groups', [
            'name' => 'Main Sidebar',
            'slug' => 'main-sidebar',
            'position' => 'sidebar',
            'tenant_id' => $this->tenant->id,
        ]);

        // Audit-first: verify audit log was created
        $this->assertDatabaseHas('audit_logs', [
            'event' => 'menu.group.created',
        ]);
    }

    public function test_admin_can_create_menu_item(): void
    {
        $group = MenuGroup::create([
            'tenant_id' => $this->tenant->id,
            'name' => 'Sidebar',
            'slug' => 'sidebar',
            'position' => 'sidebar',
        ]);

        $response = $this->actingAs($this->adminUser)
            ->withoutMiddleware(TenantMiddleware::class)
            ->post(route('admin.menu.items.store'), [
                'menu_group_id' => $group->id,
                'title' => 'Dashboard',
                'type' => 'route',
                'route_name' => 'dashboard',
                'icon' => 'ph-house',
            ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('menu_items', [
            'title' => 'Dashboard',
            'type' => 'route',
            'tenant_id' => $this->tenant->id,
            'menu_group_id' => $group->id,
        ]);

        // Audit-first
        $this->assertDatabaseHas('audit_logs', [
            'event' => 'menu.item.created',
        ]);
    }

    public function test_admin_can_update_menu_group(): void
    {
        $group = MenuGroup::create([
            'tenant_id' => $this->tenant->id,
            'name' => 'Old Name',
            'slug' => 'old-name',
            'position' => 'sidebar',
        ]);

        $response = $this->actingAs($this->adminUser)
            ->withoutMiddleware(TenantMiddleware::class)
            ->put(route('admin.menu.groups.update', $group), [
                'name' => 'New Name',
                'position' => 'topbar',
            ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('menu_groups', [
            'id' => $group->id,
            'name' => 'New Name',
            'position' => 'topbar',
        ]);

        $this->assertDatabaseHas('audit_logs', [
            'event' => 'menu.group.updated',
        ]);
    }

    public function test_admin_can_delete_menu_group(): void
    {
        $group = MenuGroup::create([
            'tenant_id' => $this->tenant->id,
            'name' => 'To Delete',
            'slug' => 'to-delete',
            'position' => 'sidebar',
        ]);

        $response = $this->actingAs($this->adminUser)
            ->withoutMiddleware(TenantMiddleware::class)
            ->delete(route('admin.menu.groups.destroy', $group));

        $response->assertRedirect();

        $this->assertDatabaseMissing('menu_groups', ['id' => $group->id]);

        $this->assertDatabaseHas('audit_logs', [
            'event' => 'menu.group.deleted',
        ]);
    }

    // ─── Tenant Isolation Tests (Rule 6) ─────────────────

    public function test_tenant_isolation_prevents_cross_tenant_update(): void
    {
        $otherTenant = Tenant::create([
            'name' => 'Other Tenant',
            'slug' => 'other-tenant',
            'is_active' => true,
        ]);

        $otherGroup = MenuGroup::create([
            'tenant_id' => $otherTenant->id,
            'name' => 'Other Menu',
            'slug' => 'other-menu',
            'position' => 'sidebar',
        ]);

        // Try to update another tenant's group — controller should abort 403
        $response = $this->actingAs($this->adminUser)
            ->withoutMiddleware(TenantMiddleware::class)
            ->put(route('admin.menu.groups.update', $otherGroup), [
                'name' => 'Hacked',
                'position' => 'sidebar',
            ]);

        $response->assertStatus(403);

        // Verify data was not changed
        $this->assertDatabaseHas('menu_groups', [
            'id' => $otherGroup->id,
            'name' => 'Other Menu',
        ]);
    }

    public function test_tenant_isolation_prevents_cross_tenant_delete(): void
    {
        $otherTenant = Tenant::create([
            'name' => 'Other Tenant 2',
            'slug' => 'other-tenant-2',
            'is_active' => true,
        ]);

        $otherGroup = MenuGroup::create([
            'tenant_id' => $otherTenant->id,
            'name' => 'OG',
            'slug' => 'og',
            'position' => 'sidebar',
        ]);

        $otherItem = MenuItem::create([
            'tenant_id' => $otherTenant->id,
            'menu_group_id' => $otherGroup->id,
            'title' => 'Sensitive Item',
            'type' => 'url',
            'url' => '/secret',
        ]);

        $response = $this->actingAs($this->adminUser)
            ->withoutMiddleware(TenantMiddleware::class)
            ->delete(route('admin.menu.items.destroy', $otherItem));

        $response->assertStatus(403);

        $this->assertDatabaseHas('menu_items', ['id' => $otherItem->id]);
    }

    // ─── Reorder + Audit Tests ───────────────────────────

    public function test_move_up_swaps_order_and_creates_audit(): void
    {
        $group = MenuGroup::create([
            'tenant_id' => $this->tenant->id,
            'name' => 'Nav',
            'slug' => 'nav',
            'position' => 'sidebar',
        ]);

        $item1 = MenuItem::create([
            'tenant_id' => $this->tenant->id,
            'menu_group_id' => $group->id,
            'title' => 'First',
            'type' => 'url',
            'url' => '/first',
            'sort_order' => 0,
        ]);

        $item2 = MenuItem::create([
            'tenant_id' => $this->tenant->id,
            'menu_group_id' => $group->id,
            'title' => 'Second',
            'type' => 'url',
            'url' => '/second',
            'sort_order' => 1,
        ]);

        $response = $this->actingAs($this->adminUser)
            ->withoutMiddleware(TenantMiddleware::class)
            ->get(route('admin.menu.items.moveUp', $item2));

        $response->assertRedirect();

        // Verify sort_order swapped
        $this->assertEquals(0, $item2->fresh()->sort_order);
        $this->assertEquals(1, $item1->fresh()->sort_order);

        // Audit-first
        $this->assertDatabaseHas('audit_logs', [
            'event' => 'menu.item.moved_up',
        ]);
    }

    public function test_move_down_swaps_order_and_creates_audit(): void
    {
        $group = MenuGroup::create([
            'tenant_id' => $this->tenant->id,
            'name' => 'Nav2',
            'slug' => 'nav2',
            'position' => 'sidebar',
        ]);

        $item1 = MenuItem::create([
            'tenant_id' => $this->tenant->id,
            'menu_group_id' => $group->id,
            'title' => 'Alpha',
            'type' => 'url',
            'url' => '/alpha',
            'sort_order' => 0,
        ]);

        $item2 = MenuItem::create([
            'tenant_id' => $this->tenant->id,
            'menu_group_id' => $group->id,
            'title' => 'Beta',
            'type' => 'url',
            'url' => '/beta',
            'sort_order' => 1,
        ]);

        $response = $this->actingAs($this->adminUser)
            ->withoutMiddleware(TenantMiddleware::class)
            ->get(route('admin.menu.items.moveDown', $item1));

        $response->assertRedirect();

        $this->assertEquals(1, $item1->fresh()->sort_order);
        $this->assertEquals(0, $item2->fresh()->sort_order);

        $this->assertDatabaseHas('audit_logs', [
            'event' => 'menu.item.moved_down',
        ]);
    }

    // ─── MenuService Unit Test ───────────────────────────

    public function test_menu_service_get_tree_returns_tenant_scoped_data(): void
    {
        $group = MenuGroup::create([
            'tenant_id' => $this->tenant->id,
            'name' => 'Sidebar',
            'slug' => 'sidebar',
            'position' => 'sidebar',
            'is_active' => true,
        ]);

        MenuItem::create([
            'tenant_id' => $this->tenant->id,
            'menu_group_id' => $group->id,
            'title' => 'Dashboard',
            'type' => 'route',
            'route_name' => 'dashboard',
            'icon' => 'ph-house',
            'is_active' => true,
            'sort_order' => 0,
        ]);

        // Create item for different tenant (should NOT appear)
        $otherTenant = Tenant::create([
            'name' => 'Other',
            'slug' => 'other',
            'is_active' => true,
        ]);

        $otherGroup = MenuGroup::create([
            'tenant_id' => $otherTenant->id,
            'name' => 'Sidebar',
            'slug' => 'sidebar',
            'position' => 'sidebar',
            'is_active' => true,
        ]);

        MenuItem::create([
            'tenant_id' => $otherTenant->id,
            'menu_group_id' => $otherGroup->id,
            'title' => 'Secret Page',
            'type' => 'url',
            'url' => '/secret',
            'is_active' => true,
            'sort_order' => 0,
        ]);

        $menuService = app(\App\Contracts\Menu\MenuServiceContract::class);
        $tree = $menuService->getTree('sidebar', $this->tenant->id);

        // Should only contain our tenant's item
        $this->assertCount(1, $tree);
        $this->assertEquals('Dashboard', $tree[0]['title']);
    }
}
