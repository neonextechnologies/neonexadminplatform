<?php

namespace Modules\Example\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\ModuleContract;

/**
 * Example Module Service Provider
 * 
 * Demonstrates module structure and ModuleContract implementation
 * 
 * Phase 0A: Example module for testing module loader
 */
class ExampleServiceProvider extends ServiceProvider implements ModuleContract
{
    /**
     * Module name
     *
     * @var string
     */
    protected string $name = 'Example';

    /**
     * Module version
     *
     * @var string
     */
    protected string $version = '1.0.0';

    /**
     * Module enabled status
     *
     * @var bool
     */
    protected bool $enabled = true;

    /**
     * Get the module name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get the module version
     *
     * @return string
     */
    public function getVersion(): string
    {
        return $this->version;
    }

    /**
     * Register module services
     *
     * @return void
     */
    public function register(): void
    {
        // Register module services here
    }

    /**
     * Boot module services
     *
     * @return void
     */
    public function boot(): void
    {
        // Module boot logic here
        // Routes, views, migrations will be loaded by ModuleServiceProvider
    }

    /**
     * Get module dependencies
     *
     * @return array
     */
    public function getDependencies(): array
    {
        return [];
    }

    /**
     * Check if module is enabled
     *
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->enabled;
    }
}
