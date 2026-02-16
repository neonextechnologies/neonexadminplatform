<?php

/**
 * Global Helper Functions
 * 
 * Phase 0B: Theme helpers
 * Layer A: Minimal, focused helpers only
 */

if (!function_exists('theme')) {
    /**
     * Get theme service instance
     *
     * @return \App\Services\ThemeService
     */
    function theme(): \App\Services\ThemeService
    {
        return app('theme');
    }
}

if (!function_exists('theme_view')) {
    /**
     * Get theme view path
     *
     * @param string $view
     * @return string
     */
    function theme_view(string $view): string
    {
        return theme()->view($view);
    }
}

if (!function_exists('theme_asset')) {
    /**
     * Get theme asset URL
     *
     * @param string $path
     * @return string
     */
    function theme_asset(string $path): string
    {
        $theme = config('theme.active', 'plain');
        $assetsPath = config('theme.assets_path', 'themes');
        
        return asset("{$assetsPath}/{$theme}/{$path}");
    }
}

if (!function_exists('render_theme_assets')) {
    /**
     * Render theme assets (CSS or JS)
     *
     * @param string $type - 'css' or 'js'
     * @return string
     */
    function render_theme_assets(string $type = 'css'): string
    {
        return theme()->renderAssets($type);
    }
}

if (!function_exists('tenant_id')) {
    /**
     * Get current tenant ID
     * 
     * Phase 5: Will be implemented with TenantService
     * Phase 0: Stub only
     *
     * @return int|null
     */
    function tenant_id(): ?int
    {
        // Stub for Phase 0 - will be implemented in Phase 5
        return session('tenant_id');
    }
}

if (!function_exists('has_permission')) {
    /**
     * Check if current user has permission
     * 
     * Phase 2: Will be implemented with RBAC
     * Phase 0: Stub only
     *
     * @param string $permission
     * @return bool
     */
    function has_permission(string $permission): bool
    {
        // Stub for Phase 0 - will be implemented in Phase 2
        return auth()->check();
    }
}

if (!function_exists('audit')) {
    /**
     * Get audit service instance
     * 
     * Phase 3: Full AuditService implementation
     *
     * @return \App\Contracts\AuditContract
     */
    function audit(): \App\Contracts\AuditContract
    {
        return app('audit');
    }
}

if (!function_exists('setting')) {
    /**
     * Get setting service instance
     * 
     * Phase 4: Tenant-aware settings with cache-first pattern
     * 
     * Usage:
     *   setting()->get('app', 'site_name', 'Default')
     *   setting()->set('app', 'site_name', 'My Site')
     *
     * @return \App\Services\SettingService
     */
    function setting(): \App\Services\SettingService
    {
        return app('setting');
    }
}
