@extends('theme::layouts.app')

@section('title', 'Phase 2 Test - RBAC')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">✅ Phase 2: RBAC - Test Summary</h5>
            </div>
            <div class="card-body">
                <div class="alert alert-success">
                    <h6 class="alert-heading">
                        <i class="bi bi-shield-check-fill me-2"></i>Phase 2 Completed Successfully!
                    </h6>
                    <p class="mb-0">RBAC system with registry-first + audit-first approach is ready.</p>
                </div>

                <h6 class="fw-bold mt-4 mb-3">📋 Current User Info:</h6>
                <div class="card border-info">
                    <div class="card-body">
                        @auth
                            <p class="mb-2"><strong>Name:</strong> {{ auth()->user()->name }}</p>
                            <p class="mb-2"><strong>Email:</strong> {{ auth()->user()->email }}</p>
                            <p class="mb-2"><strong>ID:</strong> {{ auth()->user()->id }}</p>
                            
                            <hr>
                            
                            <p class="mb-2"><strong>Roles:</strong></p>
                            <div class="mb-3">
                                @forelse(auth()->user()->roles as $role)
                                    <span class="badge bg-primary me-1">{{ $role->label }} ({{ $role->name }})</span>
                                @empty
                                    <span class="badge bg-secondary">No roles assigned</span>
                                @endforelse
                            </div>

                            <p class="mb-2"><strong>Permissions:</strong></p>
                            <div class="mb-0">
                                @php
                                    $permissions = auth()->user()->roles->flatMap->permissions->unique('id');
                                @endphp
                                @forelse($permissions as $permission)
                                    <span class="badge bg-success me-1 mb-1">{{ $permission->label }} ({{ $permission->name }})</span>
                                @empty
                                    <span class="badge bg-secondary">No permissions assigned</span>
                                @endforelse
                            </div>
                        @else
                            <p class="mb-0"><strong>Status:</strong> Not logged in</p>
                        @endauth
                    </div>
                </div>

                <h6 class="fw-bold mt-4 mb-3">🧪 Permission Tests:</h6>
                
                <div class="row g-3">
                    <!-- Test 1: users.view -->
                    <div class="col-md-6">
                        <div class="card border-success">
                            <div class="card-header bg-success text-white">
                                <strong>Test 1: users.view Permission</strong>
                            </div>
                            <div class="card-body">
                                <p class="small">Route protected by: <code>permission:users.view</code></p>
                                <p class="small mb-3">Admin should ✅ access, User should ✅ access, Guest should ❌ forbidden</p>
                                <a href="{{ route('test.permission', 'users.view') }}" class="btn btn-sm btn-success" target="_blank">
                                    Test Access
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Test 2: users.create -->
                    <div class="col-md-6">
                        <div class="card border-warning">
                            <div class="card-header bg-warning">
                                <strong>Test 2: users.create Permission</strong>
                            </div>
                            <div class="card-body">
                                <p class="small">Route protected by: <code>permission:users.create</code></p>
                                <p class="small mb-3">Admin should ✅ access, User should ❌ forbidden, Guest should ❌ forbidden</p>
                                <a href="{{ route('test.permission', 'users.create') }}" class="btn btn-sm btn-warning" target="_blank">
                                    Test Access
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Test 3: users.delete -->
                    <div class="col-md-6">
                        <div class="card border-danger">
                            <div class="card-header bg-danger text-white">
                                <strong>Test 3: users.delete Permission</strong>
                            </div>
                            <div class="card-body">
                                <p class="small">Route protected by: <code>permission:users.delete</code></p>
                                <p class="small mb-3">Admin should ✅ access, User should ❌ forbidden, Guest should ❌ forbidden</p>
                                <a href="{{ route('test.permission', 'users.delete') }}" class="btn btn-sm btn-danger" target="_blank">
                                    Test Access
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Test 4: roles.create -->
                    <div class="col-md-6">
                        <div class="card border-info">
                            <div class="card-header bg-info text-white">
                                <strong>Test 4: roles.create Permission</strong>
                            </div>
                            <div class="card-body">
                                <p class="small">Route protected by: <code>permission:roles.create</code></p>
                                <p class="small mb-3">Admin should ✅ access, User should ❌ forbidden, Guest should ❌ forbidden</p>
                                <a href="{{ route('test.permission', 'roles.create') }}" class="btn btn-sm btn-info" target="_blank">
                                    Test Access
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <h6 class="fw-bold mt-4 mb-3">📊 Database Stats:</h6>
                <div class="table-responsive">
                    <table class="table table-sm table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>Entity</th>
                                <th>Count</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Roles</td>
                                <td><span class="badge bg-primary">{{ \App\Models\Role::count() }}</span></td>
                            </tr>
                            <tr>
                                <td>Permissions</td>
                                <td><span class="badge bg-success">{{ \App\Models\Permission::count() }}</span></td>
                            </tr>
                            <tr>
                                <td>Users</td>
                                <td><span class="badge bg-info">{{ \App\Models\User::count() }}</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="alert alert-warning mt-4">
                    <h6 class="alert-heading">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>How to Test
                    </h6>
                    <ol class="mb-0">
                        <li>Login as <code>admin@example.com</code> - should access ALL test links</li>
                        <li>Login as <code>user@example.com</code> - should access <code>users.view</code> only</li>
                        <li>Create a guest user - should get 403 Forbidden on most routes</li>
                    </ol>
                </div>

                <div class="mt-4 d-flex gap-2">
                    <a href="/_test-phase1" class="btn btn-secondary">← Phase 1 Test</a>
                    <a href="/_shell" class="btn btn-info">UI Shell</a>
                    @auth
                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-warning">Logout & Switch User</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
