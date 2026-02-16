<?php

namespace App\Services;

/**
 * Theme Service
 * 
 * Provides theme-related functionality like asset rendering,
 * view resolution, and theme switching
 * 
 * Phase 0B: Theme service foundation
 */
class ThemeService
{
    /**
     * Get active theme name
     *
     * @return string
     */
    public function getActiveTheme(): string
    {
        return config('theme.active', 'plain');
    }

    /**
     * Get theme configuration
     *
     * @param string|null $theme
     * @return array
     */
    public function getThemeConfig(?string $theme = null): array
    {
        $theme = $theme ?? $this->getActiveTheme();
        return config("theme.themes.{$theme}", []);
    }

    /**
     * Get theme assets
     *
     * @param string $type - 'css' or 'js'
     * @param string|null $theme
     * @return array
     */
    public function getAssets(string $type, ?string $theme = null): array
    {
        $config = $this->getThemeConfig($theme);
        return $config['assets'][$type] ?? [];
    }

    /**
     * Render theme assets as HTML
     *
     * @param string $type - 'css' or 'js'
     * @return string
     */
    public function renderAssets(string $type): string
    {
        $assets = $this->getAssets($type);
        $html = [];

        foreach ($assets as $asset) {
            if ($type === 'css') {
                $html[] = '<link rel="stylesheet" href="' . $this->resolveAssetUrl($asset) . '">';
            } elseif ($type === 'js') {
                $html[] = '<script src="' . $this->resolveAssetUrl($asset) . '"></script>';
            }
        }

        return implode("\n    ", $html);
    }

    /**
     * Resolve asset URL (CDN or local)
     *
     * @param string $asset
     * @return string
     */
    protected function resolveAssetUrl(string $asset): string
    {
        // If URL starts with http:// or https://, it's a CDN URL
        if (str_starts_with($asset, 'http://') || str_starts_with($asset, 'https://')) {
            return $asset;
        }

        // Otherwise, it's a local asset
        return asset($asset);
    }

    /**
     * Get theme view path
     *
     * @param string $view
     * @return string
     */
    public function view(string $view): string
    {
        $theme = $this->getActiveTheme();
        return "themes.{$theme}.{$view}";
    }
}
