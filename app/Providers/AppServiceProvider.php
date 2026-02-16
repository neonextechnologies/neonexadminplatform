<?php

namespace App\Providers;

use App\Contracts\PermissionRegistryContract;
use App\Services\PermissionRegistry;
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

        // Alias for easier access
        $this->app->alias(PermissionRegistryContract::class, 'permission.registry');
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
