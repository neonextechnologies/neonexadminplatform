<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Active Theme
    |--------------------------------------------------------------------------
    |
    | The currently active theme. This determines which theme folder
    | in resources/themes/ will be used for rendering views.
    |
    | Supported themes:
    | - 'plain' (default, minimal Bootstrap 5)
    | - 'limitless' (optional, if you have Limitless theme files)
    | - 'adminlte4' (optional, future support)
    |
    */

    'active' => env('APP_THEME', 'plain'),

    /*
    |--------------------------------------------------------------------------
    | Theme Adapter Policy
    |--------------------------------------------------------------------------
    |
    | Theme adapter allows switching themes without changing feature code.
    | All views should use theme_view() helper or ThemeServiceProvider methods.
    |
    | Phase 0B: We start with 'plain' Bootstrap theme (CDN-first)
    | Layer A: No component library yet (plain Bootstrap markup only)
    |
    */

    'themes' => [
        'plain' => [
            'name' => 'Plain Bootstrap',
            'description' => 'Minimal Bootstrap 5 theme (CDN-based)',
            'version' => '1.0.0',
            'author' => 'NeonEx',
            'assets' => [
                'css' => [
                    // Bootstrap 5 CDN
                    'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css',
                    // Custom CSS (if any)
                    '/css/app.css',
                ],
                'js' => [
                    // jQuery CDN
                    'https://code.jquery.com/jquery-3.6.1.min.js',
                    // Bootstrap JS Bundle CDN
                    'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js',
                    // Action Router (Phase 0A)
                    '/js/app.js',
                ],
            ],
        ],

        'limitless' => [
            'name' => 'Limitless Admin',
            'description' => 'Limitless Admin Template (Phase 8.0 Layer B)',
            'version' => '4.0.0',
            'author' => 'Kopyov',
            'assets' => [
                'css' => [
                    // Limitless font
                    '/themes/limitless/assets/fonts/db/db.css',
                    // Icon packs (Limitless uses Phosphor, Icomoon, FontAwesome, Material)
                    '/themes/limitless/assets/icons/phosphor/styles.min.css',
                    '/themes/limitless/assets/icons/icomoon/styles.min.css',
                    '/themes/limitless/assets/icons/fontawesome/styles.min.css',
                    '/themes/limitless/assets/icons/material/styles.min.css',
                    // Bootstrap Icons (for backward compat with Layer A views)
                    'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css',
                    // Limitless main CSS (LTR)
                    '/themes/limitless/assets/css/ltr/all.min.css',
                ],
                'js' => [
                    // jQuery (from Limitless local)
                    '/themes/limitless/assets/js/jquery/jquery.min.js',
                    // Bootstrap JS Bundle (from Limitless local)
                    '/themes/limitless/assets/js/bootstrap/bootstrap.bundle.min.js',
                    // Limitless core app JS
                    '/themes/limitless/assets/js/app.js',
                    // Notification libraries (Limitless)
                    '/themes/limitless/assets/js/vendor/notifications/noty.min.js',
                    '/themes/limitless/assets/js/vendor/notifications/sweet_alert.min.js',
                    // Action Router (Phase 0A - our custom)
                    '/js/app.js',
                ],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Asset Loading Policy
    |--------------------------------------------------------------------------
    |
    | CDN-first: Use CDN for common libraries (Bootstrap, jQuery)
    | Local: Only for theme-specific files or when CDN is unavailable
    |
    | Per-page assets: Load heavy plugins (DataTables, etc.) only on pages that need them
    | Phase 0B: No DataTables yet (deferred to Phase 8 / Layer C)
    |
    */

    'asset_policy' => 'cdn-first',

    /*
    |--------------------------------------------------------------------------
    | Views Path
    |--------------------------------------------------------------------------
    |
    | Base path for theme views relative to resources/ directory
    |
    */

    'views_path' => 'themes',

    /*
    |--------------------------------------------------------------------------
    | Public Assets Path
    |--------------------------------------------------------------------------
    |
    | Base path for theme assets in public/ directory
    |
    */

    'assets_path' => 'themes',

];
