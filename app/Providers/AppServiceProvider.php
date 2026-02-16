<?php

namespace App\Providers;

use App\Contracts\AuditContract;
use App\Contracts\PermissionRegistryContract;
use App\Services\AuditService;
use App\Services\PermissionRegistry;
use App\Services\SettingService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Phase 2: Register PermissionRegistry (registry-first)
        $this->app->singleton(PermissionRegistryContract::class, function ($app) {
            return new PermissionRegistry();
        });
        $this->app->alias(PermissionRegistryContract::class, 'permission.registry');

        // Phase 3: Register AuditService (audit-first)
        $this->app->singleton(AuditContract::class, function ($app) {
            return new AuditService();
        });
        $this->app->alias(AuditContract::class, 'audit');

        // Phase 4: Register SettingService (tenant-aware, cache-first)
        $this->app->singleton(SettingService::class, function ($app) {
            return new SettingService();
        });
        $this->app->alias(SettingService::class, 'setting');
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
