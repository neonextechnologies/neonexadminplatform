<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Permission Middleware
 * 
 * Phase 2: RBAC permission checking
 * Registry-first: Permissions must be registered via PermissionRegistry
 * 
 * Usage:
 * Route::middleware(['auth', 'permission:users.view'])->group(...);
 */
class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $permission  Permission name (e.g., 'users.view')
     */
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        $user = $request->user();

        // Check if user is authenticated
        if (!$user) {
            abort(401, 'Unauthenticated');
        }

        // Check if user has permission
        if (!$user->canDo($permission)) {
            // Audit-first: Log unauthorized access attempt
            logger()->warning('Unauthorized permission access attempt', [
                'user_id' => $user->id,
                'user_email' => $user->email,
                'permission' => $permission,
                'url' => $request->url(),
                'ip_address' => $request->ip(),
            ]);

            abort(403, "Unauthorized. Missing permission: {$permission}");
        }

        return $next($request);
    }
}
