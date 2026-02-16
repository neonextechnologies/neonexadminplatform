<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\File;
use App\Contracts\ModuleContract;

/**
 * Module Service Provider
 * 
 * Loads and boots pluggable modules from modules/ directory
 * Modules MUST implement ModuleContract to be loaded
 * 
 * Phase 0A: Module runtime foundation
 */
class ModuleServiceProvider extends ServiceProvider
{
    /**
     * Loaded modules
     *
     * @var array
     */
    protected array $modules = [];

    /**
     * Modules path
     *
     * @var string
     */
    protected string $modulesPath;

    /**
     * Register services.
     */
    public function register(): void
    {
        // Discover and register modules
        $this->discoverModules();

        // Register each module
        foreach ($this->modules as $module) {
            if ($module->isEnabled()) {
                $module->register();
            }
        }
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Boot each module
        foreach ($this->modules as $module) {
            if ($module->isEnabled()) {
                $this->bootModule($module);
            }
        }
    }

    /**
     * Discover modules in modules/ directory
     *
     * @return void
     */
    protected function discoverModules(): void
    {
        $this->modulesPath = base_path('modules');
        
        if (!File::isDirectory($this->modulesPath)) {
            return;
        }

        $directories = File::directories($this->modulesPath);

        foreach ($directories as $directory) {
            $moduleName = basename($directory);
            $providerClass = "Modules\\{$moduleName}\\Providers\\{$moduleName}ServiceProvider";

            if (class_exists($providerClass)) {
                // Instantiate module provider with app container
                $provider = new $providerClass($this->app);
                
                if ($provider instanceof ModuleContract) {
                    $this->modules[$moduleName] = $provider;
                }
            }
        }
    }

    /**
     * Boot a module
     *
     * @param ModuleContract $module
     * @return void
     */
    protected function bootModule(ModuleContract $module): void
    {
        $moduleName = $module->getName();
        $modulePath = $this->modulesPath . '/' . $moduleName;

        // Boot the module
        $module->boot();

        // Load module routes
        $this->loadModuleRoutes($modulePath);

        // Load module views
        $this->loadModuleViews($moduleName, $modulePath);

        // Load module migrations
        $this->loadModuleMigrations($modulePath);

        // Load module translations
        $this->loadModuleTranslations($moduleName, $modulePath);
    }

    /**
     * Load module routes
     *
     * @param string $modulePath
     * @return void
     */
    protected function loadModuleRoutes(string $modulePath): void
    {
        $webRoutes = $modulePath . '/routes/web.php';
        $apiRoutes = $modulePath . '/routes/api.php';

        if (File::exists($webRoutes)) {
            $this->loadRoutesFrom($webRoutes);
        }

        if (File::exists($apiRoutes)) {
            $this->loadRoutesFrom($apiRoutes);
        }
    }

    /**
     * Load module views
     *
     * @param string $moduleName
     * @param string $modulePath
     * @return void
     */
    protected function loadModuleViews(string $moduleName, string $modulePath): void
    {
        $viewsPath = $modulePath . '/resources/views';

        if (File::isDirectory($viewsPath)) {
            $this->loadViewsFrom($viewsPath, strtolower($moduleName));
        }
    }

    /**
     * Load module migrations
     *
     * @param string $modulePath
     * @return void
     */
    protected function loadModuleMigrations(string $modulePath): void
    {
        $migrationsPath = $modulePath . '/database/migrations';

        if (File::isDirectory($migrationsPath)) {
            $this->loadMigrationsFrom($migrationsPath);
        }
    }

    /**
     * Load module translations
     *
     * @param string $moduleName
     * @param string $modulePath
     * @return void
     */
    protected function loadModuleTranslations(string $moduleName, string $modulePath): void
    {
        $langPath = $modulePath . '/resources/lang';

        if (File::isDirectory($langPath)) {
            $this->loadTranslationsFrom($langPath, strtolower($moduleName));
        }
    }

    /**
     * Get all loaded modules
     *
     * @return array
     */
    public function getModules(): array
    {
        return $this->modules;
    }
}
