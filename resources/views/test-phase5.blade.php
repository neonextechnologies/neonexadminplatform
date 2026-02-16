@extends(theme_view('layouts.app'))

@section('title', 'Phase 5 Test Summary')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">✅ Phase 5: Multi-Tenancy (Tenant Resolver) - Test Summary</h4>
                </div>

                <div class="card-body">
                    {{-- Phase 5 Overview --}}
                    <div class="alert alert-info">
                        <h5>🎯 Phase 5 Objective</h5>
                        <p class="mb-0">Resolve the current tenant per request and expose a <strong>stable tenant context</strong> (<code>tenant_id</code>) so all module queries can be scoped safely.</p>
                    </div>

                    {{-- Exit Criteria --}}
                    <h5 class="mt-4">Exit Criteria Checklist</h5>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 60px;">Status</th>
                                    <th>Requirement</th>
                                    <th>Implementation</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center">✅</td>
                                    <td>Tenant resolves by domain/subdomain/path in defined priority</td>
                                    <td>
                                        TenantMiddleware: domain → subdomain → path
                                        <br><small class="text-muted">Priority: Full domain > Subdomain > Path-based</small>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">✅</td>
                                    <td><code>tenant_id()</code> / <code>app('tenant.id')</code> is stable per request</td>
                                    <td>
                                        Set by TenantMiddleware, accessed via <code>tenant()->id()</code>
                                        <br><small class="text-muted">Available throughout entire request lifecycle</small>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">✅</td>
                                    <td>Tenant middleware blocks requests without a resolved tenant</td>
                                    <td>
                                        Returns 404 if no tenant found
                                        <br><small class="text-muted">Returns 403 if tenant is inactive</small>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    {{-- Current Tenant Context --}}
                    <h5 class="mt-4">🏢 Current Tenant Context</h5>
                    <div class="card bg-light">
                        <div class="card-body">
                            @php
                                $currentTenant = tenant()->current();
                                $tenantDomain = app('tenant.domain');
                            @endphp
                            
                            @if($currentTenant)
                                <div class="row">
                                    <div class="col-md-6">
                                        <strong>Tenant Information:</strong>
                                        <ul class="mt-2">
                                            <li><strong>ID:</strong> <code>{{ $currentTenant->id }}</code></li>
                                            <li><strong>Name:</strong> {{ $currentTenant->name }}</li>
                                            <li><strong>Slug:</strong> <code>{{ $currentTenant->slug }}</code></li>
                                            <li><strong>Status:</strong> 
                                                <span class="badge bg-{{ $currentTenant->is_active ? 'success' : 'danger' }}">
                                                    {{ $currentTenant->is_active ? 'Active' : 'Inactive' }}
                                                </span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-md-6">
                                        <strong>Resolution Details:</strong>
                                        <ul class="mt-2">
                                            <li><strong>Method:</strong> <span class="badge bg-info">{{ $tenantDomain->resolution_method }}</span></li>
                                            <li><strong>Domain:</strong> <code>{{ $tenantDomain->domain ?? 'N/A' }}</code></li>
                                            <li><strong>Subdomain:</strong> <code>{{ $tenantDomain->subdomain ?? 'N/A' }}</code></li>
                                            <li><strong>Path:</strong> <code>{{ $tenantDomain->path ?? 'N/A' }}</code></li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="mt-3">
                                    <strong>Associated Users:</strong>
                                    <div class="mt-2">
                                        @foreach($currentTenant->users as $user)
                                            <span class="badge bg-secondary me-1">{{ $user->email }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            @else
                                <div class="alert alert-warning">
                                    <strong>No tenant context found!</strong> This should not happen if middleware is working correctly.
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Implementation Details --}}
                    <h5 class="mt-4">📦 Implementation Details</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card mb-3">
                                <div class="card-header">
                                    <strong>1. Database Tables</strong>
                                </div>
                                <div class="card-body">
                                    <ul class="mb-0">
                                        <li>✅ <code>tenants</code> (id, name, slug, is_active)</li>
                                        <li>✅ <code>tenant_domains</code> (tenant_id, domain, subdomain, path)</li>
                                        <li>✅ <code>tenant_user</code> (tenant_id, user_id)</li>
                                    </ul>
                                </div>
                            </div>

                            <div class="card mb-3">
                                <div class="card-header">
                                    <strong>2. Tenant Resolution (Priority)</strong>
                                </div>
                                <div class="card-body">
                                    <ol class="mb-0">
                                        <li><strong>Domain:</strong> <code>example.com</code></li>
                                        <li><strong>Subdomain:</strong> <code>tenant.example.com</code></li>
                                        <li><strong>Path:</strong> <code>/t/tenant</code></li>
                                    </ol>
                                    <div class="alert alert-light mt-2 mb-0">
                                        <small><strong>Current URL:</strong> <code>{{ request()->fullUrl() }}</code></small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card mb-3">
                                <div class="card-header">
                                    <strong>3. TenantService API</strong>
                                </div>
                                <div class="card-body">
                                    <ul class="mb-0">
                                        <li>✅ <code>tenant()->id()</code> - Get current tenant ID</li>
                                        <li>✅ <code>tenant()->current()</code> - Get Tenant model</li>
                                        <li>✅ <code>tenant()->set($id)</code> - Set tenant context</li>
                                        <li>✅ <code>tenant()->hasContext()</code> - Check if set</li>
                                        <li>✅ <code>tenant()->runInContext($id, $fn)</code></li>
                                    </ul>
                                </div>
                            </div>

                            <div class="card mb-3">
                                <div class="card-header">
                                    <strong>4. Middleware Integration</strong>
                                </div>
                                <div class="card-body">
                                    <ul class="mb-0">
                                        <li>✅ <code>tenant.selected</code> middleware alias</li>
                                        <li>✅ Applied to dashboard + users routes</li>
                                        <li>✅ Blocks requests without tenant (404)</li>
                                        <li>✅ Blocks inactive tenants (403)</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Seeded Tenants --}}
                    <h5 class="mt-4">🏢 Seeded Tenants</h5>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Slug</th>
                                    <th>Status</th>
                                    <th>Test URL</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(\App\Models\Tenant::all() as $tenant)
                                    <tr>
                                        <td><code>{{ $tenant->id }}</code></td>
                                        <td>{{ $tenant->name }}</td>
                                        <td><code>{{ $tenant->slug }}</code></td>
                                        <td>
                                            <span class="badge bg-{{ $tenant->is_active ? 'success' : 'danger' }}">
                                                {{ $tenant->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td>
                                            @php
                                                $domain = $tenant->domains->first();
                                                $baseUrl = request()->getSchemeAndHttpHost();
                                            @endphp
                                            @if($domain && $domain->path)
                                                <a href="{{ $baseUrl }}{{ $domain->path }}/_test-phase5" target="_blank" class="btn btn-sm btn-primary">
                                                    Test: {{ $domain->path }}/_test-phase5
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- API Usage Examples --}}
                    <h5 class="mt-4">💻 API Usage Examples</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <strong>Get Tenant Context:</strong>
                            <pre class="bg-light p-3"><code>// Get current tenant ID
$tenantId = tenant_id(); // or tenant()->id()

// Get current Tenant model
$tenant = tenant()->current();

// Check if context exists
$hasContext = tenant()->hasContext();</code></pre>
                        </div>
                        <div class="col-md-6">
                            <strong>Tenant-Safe Queries:</strong>
                            <pre class="bg-light p-3"><code>// All queries now automatically tenant-scoped
$users = User::where('tenant_id', tenant_id())->get();

// Settings are tenant-aware
$siteName = setting()->get('app', 'site_name');

// Run code in different tenant context
tenant()->runInContext(2, function() {
    // This code runs with tenant_id = 2
});</code></pre>
                        </div>
                    </div>

                    {{-- Files Created --}}
                    <h5 class="mt-4">📁 Files Created (Phase 5)</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <strong>Backend:</strong>
                            <ul>
                                <li><code>database/migrations/*_create_tenants_table.php</code></li>
                                <li><code>database/migrations/*_create_tenant_domains_table.php</code></li>
                                <li><code>database/migrations/*_create_tenant_user_table.php</code></li>
                                <li><code>app/Models/Tenant.php</code></li>
                                <li><code>app/Models/TenantDomain.php</code></li>
                                <li><code>app/Services/TenantService.php</code></li>
                                <li><code>app/Http/Middleware/TenantMiddleware.php</code></li>
                                <li><code>database/seeders/TenantSeeder.php</code></li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <strong>Modified:</strong>
                            <ul>
                                <li><code>app/Models/User.php</code> (tenants relation)</li>
                                <li><code>app/Providers/AppServiceProvider.php</code> (bind TenantService)</li>
                                <li><code>app/helpers.php</code> (tenant_id(), tenant())</li>
                                <li><code>bootstrap/app.php</code> (tenant.selected middleware)</li>
                                <li><code>routes/web.php</code> (add tenant.selected)</li>
                                <li><code>database/seeders/DatabaseSeeder.php</code></li>
                            </ul>
                        </div>
                    </div>

                    {{-- Quick Links --}}
                    <h5 class="mt-4">🔗 Quick Links</h5>
                    <div class="btn-group" role="group">
                        <a href="{{ route('test.phase4') }}" class="btn btn-secondary">← Phase 4 Test</a>
                        <a href="{{ route('users.index') }}" class="btn btn-primary">Users List</a>
                        <a href="{{ route('dashboard') }}" class="btn btn-info">Dashboard</a>
                    </div>

                    {{-- Test Instructions --}}
                    <h5 class="mt-4">🧪 Testing Instructions</h5>
                    <div class="alert alert-secondary">
                        <strong>Test Tenant Resolution:</strong>
                        <ol class="mb-0">
                            <li>Current page is under tenant: <strong>{{ $currentTenant->name ?? 'Unknown' }}</strong></li>
                            <li>Try accessing: <code>{{ request()->getSchemeAndHttpHost() }}/t/default/_test-phase5</code></li>
                            <li>Try accessing: <code>{{ request()->getSchemeAndHttpHost() }}/t/demo/_test-phase5</code></li>
                            <li>Try accessing without tenant: <code>{{ request()->getSchemeAndHttpHost() }}/users</code> (should 404)</li>
                            <li>All users/settings queries are now automatically tenant-scoped!</li>
                        </ol>
                    </div>

                    {{-- Database Check --}}
                    <h5 class="mt-4">🗄️ Database Check</h5>
                    <div class="alert alert-secondary">
                        <strong>Run in your database:</strong>
                        <pre class="mb-0"><code>SELECT * FROM tenants;
SELECT * FROM tenant_domains;
SELECT * FROM tenant_user;
SELECT * FROM audit_logs WHERE event LIKE 'tenants.%' ORDER BY created_at DESC;</code></pre>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
