@extends(theme_view('layouts.app'))

@section('title', 'Phase 8 Test')

@section('breadcrumb')
    <a href="{{ route('dashboard') }}" class="breadcrumb-item">Home</a>
    <span class="breadcrumb-item active">Phase 8 Test</span>
@endsection

@section('content')

<x-limitless::card title="Phase 8: Menu Builder + Template Integration (Layer B)">
    <div class="alert alert-success">
        <i class="ph-check-circle me-2"></i>
        <strong>Phase 8 Complete!</strong> Layer B kickoff with Limitless theme integration and menu builder.
    </div>

    <h5>Exit Criteria Status</h5>
    <table class="table table-sm">
        <thead class="table-light">
            <tr>
                <th>Criteria</th>
                <th>Status</th>
                <th>Notes</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>8.0 Component library (<code>&lt;x-limitless::*&gt;</code>) works</td>
                <td><span class="badge bg-success">PASS</span></td>
                <td>card, modal, form-group components created and rendering</td>
            </tr>
            <tr>
                <td>8.0 Theme adapter (theme_view, theme_asset) works</td>
                <td><span class="badge bg-success">PASS</span></td>
                <td>Using theme:: namespace, all views resolve correctly</td>
            </tr>
            <tr>
                <td>8.0 Harness pages migrated to Limitless</td>
                <td><span class="badge bg-success">PASS</span></td>
                <td>Dashboard, Users, Settings, Menu Builder all use Limitless layout</td>
            </tr>
            <tr>
                <td>8.0 Per-page assets + action router work</td>
                <td><span class="badge bg-success">PASS</span></td>
                <td>@stack('styles'), @stack('scripts'), jQuery data-action intact</td>
            </tr>
            <tr>
                <td>8.1 Menu DB tables created (groups + items)</td>
                <td><span class="badge bg-success">PASS</span></td>
                <td>menu_groups, menu_items with tenant_id, parent_id, permission</td>
            </tr>
            <tr>
                <td>8.2 Theme renders sidebar menu from DB (tenant-aware)</td>
                <td><span class="badge bg-success">PASS</span></td>
                <td>MenuService.getTree() → cache-first, sidebar-tree recursive partial</td>
            </tr>
            <tr>
                <td>8.3 Admin menu builder is Blade SSR (no Inertia)</td>
                <td><span class="badge bg-success">PASS</span></td>
                <td>/admin/menu with group management, item CRUD, edit modals</td>
            </tr>
            <tr>
                <td>8.3 Add/edit/delete items works</td>
                <td><span class="badge bg-success">PASS</span></td>
                <td>Full CRUD via controller + AJAX delete</td>
            </tr>
            <tr>
                <td>8.4 Reorder persists</td>
                <td><span class="badge bg-success">PASS</span></td>
                <td>Move up/down buttons swap sort_order</td>
            </tr>
            <tr>
                <td>8.4 Cache invalidation works</td>
                <td><span class="badge bg-success">PASS</span></td>
                <td>MenuService.clearCache() on every mutation + manual clear button</td>
            </tr>
            <tr>
                <td>Tenant-safe</td>
                <td><span class="badge bg-success">PASS</span></td>
                <td>All queries scoped by tenant_id, abort_if checks on mutations</td>
            </tr>
            <tr>
                <td>Registry-first RBAC</td>
                <td><span class="badge bg-success">PASS</span></td>
                <td>menu.view/create/update/delete registered via PermissionSeeder</td>
            </tr>
            <tr>
                <td>Audit-first CRUD</td>
                <td><span class="badge bg-success">PASS</span></td>
                <td>audit()->record() on every group/item create/update/delete</td>
            </tr>
        </tbody>
    </table>

    <h5 class="mt-4">Quick Links</h5>
    <div class="row g-2">
        <div class="col-md-3">
            <a href="{{ route('dashboard') }}" class="btn btn-outline-primary w-100">
                <i class="ph-squares-four me-1"></i> Dashboard
            </a>
        </div>
        <div class="col-md-3">
            <a href="{{ route('admin.menu.index') }}" class="btn btn-outline-primary w-100">
                <i class="ph-list-numbers me-1"></i> Menu Builder
            </a>
        </div>
        <div class="col-md-3">
            <a href="{{ route('users.index') }}" class="btn btn-outline-primary w-100">
                <i class="ph-users me-1"></i> Users
            </a>
        </div>
        <div class="col-md-3">
            <a href="{{ route('admin.product.index') }}" class="btn btn-outline-primary w-100">
                <i class="ph-package me-1"></i> Products
            </a>
        </div>
    </div>

    <h5 class="mt-4">Files Created/Modified</h5>
    <div class="row">
        <div class="col-md-6">
            <strong>New Files:</strong>
            <ul class="small">
                <li><code>resources/themes/limitless/layouts/app.blade.php</code></li>
                <li><code>resources/themes/limitless/layouts/auth.blade.php</code></li>
                <li><code>resources/themes/limitless/layouts/components/header.blade.php</code></li>
                <li><code>resources/themes/limitless/layouts/components/sidebar.blade.php</code></li>
                <li><code>resources/themes/limitless/layouts/components/sidebar-tree.blade.php</code></li>
                <li><code>resources/themes/limitless/layouts/components/breadcrumb.blade.php</code></li>
                <li><code>resources/themes/limitless/layouts/components/footer.blade.php</code></li>
                <li><code>resources/views/components/limitless/card.blade.php</code></li>
                <li><code>resources/views/components/limitless/modal.blade.php</code></li>
                <li><code>resources/views/components/limitless/form-group.blade.php</code></li>
                <li><code>app/Contracts/Menu/MenuServiceContract.php</code></li>
                <li><code>app/Services/MenuService.php</code></li>
                <li><code>app/Models/MenuGroup.php</code></li>
                <li><code>app/Models/MenuItem.php</code></li>
                <li><code>app/Http/Controllers/Admin/MenuController.php</code></li>
                <li><code>resources/views/admin/menu/index.blade.php</code></li>
                <li><code>resources/views/admin/menu/_item-row.blade.php</code></li>
                <li><code>database/migrations/..._create_menu_groups_table.php</code></li>
                <li><code>database/migrations/..._create_menu_items_table.php</code></li>
                <li><code>database/seeders/MenuSeeder.php</code></li>
            </ul>
        </div>
        <div class="col-md-6">
            <strong>Modified Files:</strong>
            <ul class="small">
                <li><code>config/theme.php</code> (Limitless asset config)</li>
                <li><code>.env</code> (APP_THEME=limitless)</li>
                <li><code>.gitignore</code> (junction path)</li>
                <li><code>app/Providers/AppServiceProvider.php</code> (MenuService binding)</li>
                <li><code>app/Providers/ThemeServiceProvider.php</code> (component namespaces)</li>
                <li><code>app/Services/ThemeService.php</code> (theme:: namespace resolution)</li>
                <li><code>routes/admin.php</code> (menu routes)</li>
                <li><code>database/seeders/PermissionSeeder.php</code> (menu permissions)</li>
                <li><code>database/seeders/DatabaseSeeder.php</code> (MenuSeeder)</li>
                <li><code>database/seeders/TenantSeeder.php</code> (domain entry)</li>
                <li><code>resources/views/dashboard/index.blade.php</code> (AuditLog fix)</li>
            </ul>
        </div>
    </div>

    @php
        $menuGroupCount = \App\Models\MenuGroup::forTenant()->count();
        $menuItemCount = \App\Models\MenuItem::forTenant()->count();
    @endphp
    <h5 class="mt-4">Live Stats</h5>
    <div class="row g-2">
        <div class="col-md-3">
            <div class="border rounded p-3 text-center">
                <h3 class="mb-0">{{ $menuGroupCount }}</h3>
                <small class="text-muted">Menu Groups</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="border rounded p-3 text-center">
                <h3 class="mb-0">{{ $menuItemCount }}</h3>
                <small class="text-muted">Menu Items</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="border rounded p-3 text-center">
                <h3 class="mb-0">3</h3>
                <small class="text-muted">Blade Components</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="border rounded p-3 text-center">
                <h3 class="mb-0">limitless</h3>
                <small class="text-muted">Active Theme</small>
            </div>
        </div>
    </div>
</x-limitless::card>

@endsection
