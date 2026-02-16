@extends(theme_view('layouts.app'))

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">
    {{-- Welcome message --}}
    <div class="row mb-4">
        <div class="col-12">
            <h3>Welcome, {{ auth()->user()->name }}!</h3>
            <p class="text-muted">
                You are logged in to <strong>{{ $currentTenant->name }}</strong>
            </p>
        </div>
    </div>

    {{-- Stats Cards (Plain Bootstrap) --}}
    <div class="row">
        {{-- Users stat --}}
        <div class="col-md-3 mb-3">
            <div class="card border-primary">
                <div class="card-header bg-primary text-white">
                    <h6 class="mb-0"><i class="bi bi-people"></i> Users</h6>
                </div>
                <div class="card-body">
                    <h2 class="mb-0">{{ $stats['users'] }}</h2>
                    <small class="text-muted">In current tenant</small>
                </div>
                @if(auth()->user()->canDo('users.view'))
                    <div class="card-footer bg-transparent">
                        <a href="{{ route('users.index') }}" class="btn btn-sm btn-primary w-100">
                            View All
                        </a>
                    </div>
                @endif
            </div>
        </div>

        {{-- Roles stat --}}
        <div class="col-md-3 mb-3">
            <div class="card border-info">
                <div class="card-header bg-info text-white">
                    <h6 class="mb-0"><i class="bi bi-shield-check"></i> Roles</h6>
                </div>
                <div class="card-body">
                    <h2 class="mb-0">{{ $stats['roles'] }}</h2>
                    <small class="text-muted">System-wide</small>
                </div>
            </div>
        </div>

        {{-- Settings stat --}}
        <div class="col-md-3 mb-3">
            <div class="card border-success">
                <div class="card-header bg-success text-white">
                    <h6 class="mb-0"><i class="bi bi-gear"></i> Settings</h6>
                </div>
                <div class="card-body">
                    <h2 class="mb-0">{{ $stats['settings'] }}</h2>
                    <small class="text-muted">Tenant settings</small>
                </div>
            </div>
        </div>

        {{-- Audit logs stat --}}
        <div class="col-md-3 mb-3">
            <div class="card border-warning">
                <div class="card-header bg-warning text-white">
                    <h6 class="mb-0"><i class="bi bi-journal-text"></i> Audit Logs</h6>
                </div>
                <div class="card-body">
                    <h2 class="mb-0">{{ $stats['audit_logs'] }}</h2>
                    <small class="text-muted">Activity logs</small>
                </div>
            </div>
        </div>
    </div>

    {{-- Quick Links (Plain Bootstrap) --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-link-45deg"></i> Quick Links</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @forelse($quickLinks as $link)
                            <div class="col-md-3 col-sm-6 mb-3">
                                <a href="{{ $link['url'] }}" class="text-decoration-none">
                                    <div class="card h-100 border-2 hover-shadow">
                                        <div class="card-body text-center">
                                            <i class="bi {{ $link['icon'] }} fs-1 text-primary mb-2"></i>
                                            <h6 class="card-title">{{ $link['label'] }}</h6>
                                            <p class="card-text text-muted small">{{ $link['description'] }}</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @empty
                            <div class="col-12">
                                <p class="text-muted">No quick links available.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Current Tenant Info (Plain Bootstrap) --}}
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-building"></i> Current Tenant</h5>
                </div>
                <div class="card-body">
                    <table class="table table-sm table-borderless mb-0">
                        <tr>
                            <th style="width: 150px;">Tenant ID:</th>
                            <td><code>{{ $currentTenant->id }}</code></td>
                        </tr>
                        <tr>
                            <th>Name:</th>
                            <td><strong>{{ $currentTenant->name }}</strong></td>
                        </tr>
                        <tr>
                            <th>Slug:</th>
                            <td><code>{{ $currentTenant->slug }}</code></td>
                        </tr>
                        <tr>
                            <th>Status:</th>
                            <td>
                                <span class="badge bg-{{ $currentTenant->is_active ? 'success' : 'danger' }}">
                                    {{ $currentTenant->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Created:</th>
                            <td>{{ $currentTenant->created_at->format('Y-m-d H:i') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-person-circle"></i> Your Account</h5>
                </div>
                <div class="card-body">
                    <table class="table table-sm table-borderless mb-0">
                        <tr>
                            <th style="width: 150px;">User ID:</th>
                            <td><code>{{ auth()->user()->id }}</code></td>
                        </tr>
                        <tr>
                            <th>Name:</th>
                            <td><strong>{{ auth()->user()->name }}</strong></td>
                        </tr>
                        <tr>
                            <th>Email:</th>
                            <td>{{ auth()->user()->email }}</td>
                        </tr>
                        <tr>
                            <th>Roles:</th>
                            <td>
                                @foreach(auth()->user()->roles as $role)
                                    <span class="badge bg-secondary me-1">{{ $role->label }}</span>
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <th>Permissions:</th>
                            <td>
                                @php
                                    $permissionsCount = auth()->user()->roles->pluck('permissions')->flatten()->unique('id')->count();
                                @endphp
                                <span class="badge bg-info">{{ $permissionsCount }} permissions</span>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Recent Activity (Plain Bootstrap table) --}}
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-clock-history"></i> Recent Activity</h5>
                </div>
                <div class="card-body">
                    @php
                        $recentLogs = AuditLog::where('tenant_id', $tenantId)
                            ->orderBy('created_at', 'desc')
                            ->limit(10)
                            ->get();
                    @endphp

                    @if($recentLogs->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm table-hover">
                                <thead>
                                    <tr>
                                        <th style="width: 180px;">Time</th>
                                        <th>Event</th>
                                        <th>Actor</th>
                                        <th>Subject</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentLogs as $log)
                                        <tr>
                                            <td><small>{{ $log->created_at->format('Y-m-d H:i:s') }}</small></td>
                                            <td><code class="text-primary">{{ $log->event }}</code></td>
                                            <td>
                                                @if($log->actor)
                                                    {{ $log->actor->name }}
                                                @else
                                                    <em class="text-muted">System</em>
                                                @endif
                                            </td>
                                            <td>
                                                @if($log->subject_type)
                                                    <small class="text-muted">{{ class_basename($log->subject_type) }} #{{ $log->subject_id }}</small>
                                                @else
                                                    <small class="text-muted">-</small>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted mb-0">No recent activity.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
/* Phase 6: Minimal custom styles for dashboard hover effects */
.hover-shadow {
    transition: all 0.3s ease;
}
.hover-shadow:hover {
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    transform: translateY(-2px);
}
</style>
@endpush
