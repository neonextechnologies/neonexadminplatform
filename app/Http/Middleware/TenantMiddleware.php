<?php

namespace App\Http\Middleware;

use App\Models\TenantDomain;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * TenantMiddleware
 * 
 * Phase 5: Resolve tenant from domain/subdomain/path
 * Priority: domain → subdomain → path
 * 
 * Sets stable tenant context for the request via app('tenant')
 */
class TenantMiddleware
{
    /**
     * Handle an incoming request.
     *
     * Resolution priority:
     * 1. Full domain match (example.com)
     * 2. Subdomain match (tenant.example.com)
     * 3. Path match (/t/tenant/...)
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $host = $request->getHost();
        $path = '/' . ltrim($request->path(), '/');
        
        $tenantDomain = null;

        // Priority 1: Try full domain match
        $tenantDomain = TenantDomain::query()
            ->where('domain', $host)
            ->with('tenant')
            ->first();

        // Priority 2: Try subdomain match
        if (!$tenantDomain) {
            $parts = explode('.', $host);
            $subdomain = count($parts) > 2 ? $parts[0] : null;

            if ($subdomain) {
                $tenantDomain = TenantDomain::query()
                    ->where('subdomain', $subdomain)
                    ->with('tenant')
                    ->first();
            }
        }

        // Priority 3: Try path match (e.g., /t/tenant/...)
        if (!$tenantDomain) {
            // Convention: /t/{slug}/...
            if (preg_match('#^/t/([^/]+)#', $path, $matches)) {
                $tenantDomain = TenantDomain::query()
                    ->where('path', '/t/' . $matches[1])
                    ->with('tenant')
                    ->first();
            }
        }

        // Abort if no tenant found
        abort_if(!$tenantDomain, 404, 'Tenant not found. Please check your URL.');

        // Check if tenant is active
        abort_if(!$tenantDomain->tenant->is_active, 403, 'This tenant is not active.');

        // Set tenant context (stable for the entire request)
        app('tenant')->set($tenantDomain->tenant_id);
        
        // Also store in app container for direct access
        app()->instance('tenant.id', $tenantDomain->tenant_id);
        app()->instance('tenant.domain', $tenantDomain);

        // Audit-first: Log tenant resolution (only in debug mode to avoid log spam)
        if (config('app.debug')) {
            logger()->debug('Tenant resolved', [
                'tenant_id' => $tenantDomain->tenant_id,
                'tenant_name' => $tenantDomain->tenant->name,
                'resolution_method' => $tenantDomain->resolution_method,
                'host' => $host,
                'path' => $path,
            ]);
        }

        return $next($request);
    }
}
