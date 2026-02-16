<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\Setting;
use App\Models\Tenant;
use App\Models\User;

/**
 * DashboardController
 * 
 * Phase 6: First real admin landing page
 * - Auth + tenant protected
 * - Basic stats (tenant-scoped)
 * - Quick links to main features
 * - Plain Bootstrap markup (no component library)
 */
class DashboardController extends Controller
{
    /**
     * Display the dashboard
     */
    public function index()
    {
        $tenantId = tenant_id();
        
        // Phase 6: Basic tenant-scoped stats
        $stats = [
            'users' => User::where('tenant_id', $tenantId)->count(),
            'roles' => \App\Models\Role::count(), // Roles are global, not tenant-scoped
            'settings' => Setting::where('tenant_id', $tenantId)->count(),
            'audit_logs' => AuditLog::where('tenant_id', $tenantId)->count(),
        ];

        // Quick links to main features (permission-aware)
        $quickLinks = [];

        if (auth()->user()->canDo('users.view')) {
            $quickLinks[] = [
                'label' => 'Users',
                'url' => route('users.index'),
                'icon' => 'bi-people',
                'description' => 'Manage users',
            ];
        }

        if (auth()->user()->canDo('users.create')) {
            $quickLinks[] = [
                'label' => 'Add User',
                'url' => route('users.create'),
                'icon' => 'bi-person-plus',
                'description' => 'Create new user',
            ];
        }

        // Always show test pages (for development)
        $quickLinks[] = [
            'label' => 'Phase 5 Test',
            'url' => route('test.phase5'),
            'icon' => 'bi-clipboard-check',
            'description' => 'Test tenant resolver',
        ];

        $quickLinks[] = [
            'label' => 'Phase 4 Test',
            'url' => route('test.phase4'),
            'icon' => 'bi-gear',
            'description' => 'Test settings system',
        ];

        // Current tenant info
        $currentTenant = tenant()->current();

        return view('dashboard.index', compact('stats', 'quickLinks', 'currentTenant'));
    }
}
