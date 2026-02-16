<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;

/**
 * Theme Service Provider
 * 
 * Manages theme loading, asset rendering, and view resolution
 * Supports theme switching without changing feature code
 * 
 * Phase 0B: Theme adapter foundation
 * Layer A: Plain Bootstrap markup only (no component library yet)
 */
class ThemeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Bind theme service
        $this->app->singleton('theme', function ($app) {
            return new \App\Services\ThemeService();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Register theme view namespace
        $this->registerThemeViews();

        // Share theme data with all views
        $this->shareThemeData();

        // Register Blade directives (optional, for later)
        $this->registerBladeDirectives();
    }

    /**
     * Register theme views namespace
     *
     * @return void
     */
    protected function registerThemeViews(): void
    {
        $activeTheme = config('theme.active', 'plain');
        $viewsPath = config('theme.views_path', 'themes');
        
        $themePath = resource_path("{$viewsPath}/{$activeTheme}");

        if (is_dir($themePath)) {
            View::addNamespace('theme', $themePath);
        }
    }

    /**
     * Share theme data with all views
     *
     * @return void
     */
    protected function shareThemeData(): void
    {
        View::composer('*', function ($view) {
            $view->with('activeTheme', config('theme.active'));
        });
    }

    /**
     * Register custom Blade directives
     *
     * @return void
     */
    protected function registerBladeDirectives(): void
    {
        // @themeAssets directive for rendering CSS/JS
        Blade::directive('themeAssets', function ($type = 'css') {
            return "<?php echo render_theme_assets({$type}); ?>";
        });
    }
}
