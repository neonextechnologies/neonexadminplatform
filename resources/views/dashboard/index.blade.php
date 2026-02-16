@extends(theme_view('layouts.app'))

@section('title', 'Dashboard')

@section('breadcrumb')
    <span class="breadcrumb-item active">Dashboard</span>
@endsection

@section('content')
    {{-- Welcome message --}}
    <div class="row mb-4">
        <div class="col-12">
            <h3>Welcome, {{ auth()->user()->name }}!</h3>
            <p class="text-muted">
                You are logged in to <strong>{{ $currentTenant->name }}</strong>
            </p>
        </div>
    </div>

    {{-- Stats Cards --}}
    <div class="row">
        {{-- Users stat --}}
        <div class="col-md-3 mb-3">
            <x-limitless::card>
                <x-slot:header>
                    <h6 class="mb-0"><i class="ph-users me-1"></i> Users</h6>
                </x-slot:header>
                <h2 class="mb-0">{{ $stats['users'] }}</h2>
                <small class="text-muted">In current tenant</small>
                @if(auth()->user()->canDo('users.view'))
                <x-slot:footer>
                    <a href="{{ route('users.index') }}" class="btn btn-sm btn-primary w-100">View All</a>
                </x-slot:footer>
                @endif
            </x-limitless::card>
        </div>

        {{-- Roles stat --}}
        <div class="col-md-3 mb-3">
            <x-limitless::card>
                <x-slot:header>
                    <h6 class="mb-0"><i class="ph-shield-check me-1"></i> Roles</h6>
                </x-slot:header>
                <h2 class="mb-0">{{ $stats['roles'] }}</h2>
                <small class="text-muted">System-wide</small>
            </x-limitless::card>
        </div>

        {{-- Settings stat --}}
        <div class="col-md-3 mb-3">
            <x-limitless::card>
                <x-slot:header>
                    <h6 class="mb-0"><i class="ph-gear me-1"></i> Settings</h6>
                </x-slot:header>
                <h2 class="mb-0">{{ $stats['settings'] }}</h2>
                <small class="text-muted">Tenant settings</small>
            </x-limitless::card>
        </div>

        {{-- Audit logs stat --}}
        <div class="col-md-3 mb-3">
            <x-limitless::card>
                <x-slot:header>
                    <h6 class="mb-0"><i class="ph-clock-counter-clockwise me-1"></i> Audit Logs</h6>
                </x-slot:header>
                <h2 class="mb-0">{{ $stats['audit_logs'] }}</h2>
                <small class="text-muted">Activity logs</small>
            </x-limitless::card>
        </div>
    </div>

    {{-- Quick Links --}}
    <x-limitless::card title="Quick Links">
        <div class="row">
            @forelse($quickLinks as $link)
                <div class="col-md-3 col-sm-6 mb-3">
                    <a href="{{ $link['url'] }}" class="text-decoration-none">
                        <div class="card h-100 border-2 hover-shadow">
                            <div class="card-body text-center">
                                <i class="{{ $link['icon'] }} fs-1 text-primary mb-2 d-block"></i>
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
    </x-limitless::card>

    {{-- Current Tenant Info + Account --}}
    <div class="row mt-4">
        <div class="col-md-6">
            <x-limitless::card title="Current Tenant">
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
            </x-limitless::card>
        </div>

        <div class="col-md-6">
            <x-limitless::card title="Your Account">
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
            </x-limitless::card>
        </div>
    </div>

    {{-- Recent Activity --}}
    <div class="mt-4">
        <x-limitless::card title="Recent Activity">
            @php
                $recentLogs = \App\Models\AuditLog::where('tenant_id', tenant_id())
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
        </x-limitless::card>
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
