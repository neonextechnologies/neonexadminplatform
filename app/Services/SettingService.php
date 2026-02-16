<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

/**
 * SettingService
 * 
 * Phase 4: Tenant-aware settings service with cache-first pattern.
 * Provides get/set/forget methods for application settings.
 * 
 * Usage:
 *   setting()->get('app', 'site_name', 'Default Name');
 *   setting()->set('app', 'site_name', 'My Site');
 *   setting()->forget('app', 'site_name');
 */
class SettingService
{
    /**
     * Cache TTL in seconds (10 minutes)
     */
    protected int $cacheTtl = 600;

    /**
     * Get a setting value (cache-first pattern)
     * 
     * @param string $group Setting group (e.g., 'app', 'theme', 'i18n')
     * @param string $key Setting key
     * @param mixed $default Default value if not found
     * @return mixed
     */
    public function get(string $group, string $key, mixed $default = null): mixed
    {
        $tenantId = tenant_id(); // Phase 3 stub, will be real in Phase 5
        $cacheKey = $this->getCacheKey($tenantId, $group, $key);

        // Cache-first pattern
        return Cache::remember($cacheKey, $this->cacheTtl, function () use ($tenantId, $group, $key, $default) {
            $setting = Setting::query()
                ->where('tenant_id', $tenantId)
                ->where('group', $group)
                ->where('key', $key)
                ->first();

            return $setting ? $setting->decoded_value : $default;
        });
    }

    /**
     * Set a setting value (and invalidate cache)
     * 
     * @param string $group Setting group
     * @param string $key Setting key
     * @param mixed $value Setting value (will be auto-encoded)
     * @return Setting
     */
    public function set(string $group, string $key, mixed $value): Setting
    {
        $tenantId = tenant_id();

        $setting = Setting::updateOrCreate(
            [
                'tenant_id' => $tenantId,
                'group' => $group,
                'key' => $key,
            ],
            []
        );

        // Set value with automatic type detection
        $setting->setEncodedValue($value);
        $setting->save();

        // Invalidate cache (audit-first: clear cache immediately)
        $this->forget($group, $key);

        // Audit-first: Log setting change
        audit()->record('settings.updated', $setting, [
            'group' => $group,
            'key' => $key,
            'value' => $value,
            'type' => $setting->type,
        ]);

        return $setting;
    }

    /**
     * Delete a setting and clear its cache
     * 
     * @param string $group Setting group
     * @param string $key Setting key
     * @return bool
     */
    public function delete(string $group, string $key): bool
    {
        $tenantId = tenant_id();

        $setting = Setting::query()
            ->where('tenant_id', $tenantId)
            ->where('group', $group)
            ->where('key', $key)
            ->first();

        if (!$setting) {
            return false;
        }

        $deleted = $setting->delete();

        if ($deleted) {
            // Clear cache
            $this->forget($group, $key);

            // Audit-first: Log setting deletion
            audit()->record('settings.deleted', $setting->id, [
                'group' => $group,
                'key' => $key,
            ]);
        }

        return $deleted;
    }

    /**
     * Forget (invalidate) cache for a specific setting
     * 
     * @param string $group Setting group
     * @param string $key Setting key
     * @return void
     */
    public function forget(string $group, string $key): void
    {
        $tenantId = tenant_id();
        $cacheKey = $this->getCacheKey($tenantId, $group, $key);
        Cache::forget($cacheKey);
    }

    /**
     * Flush all settings cache for current tenant
     * 
     * @return void
     */
    public function flushCache(): void
    {
        $tenantId = tenant_id();
        
        // Clear all settings for this tenant
        // Note: This is a simple implementation. For production, consider using cache tags.
        $settings = Setting::query()
            ->where('tenant_id', $tenantId)
            ->get(['group', 'key']);

        foreach ($settings as $setting) {
            $this->forget($setting->group, $setting->key);
        }
    }

    /**
     * Get all settings for a group (with cache)
     * 
     * @param string $group Setting group
     * @return array Key-value pairs
     */
    public function getGroup(string $group): array
    {
        $tenantId = tenant_id();
        $cacheKey = "settings:{$tenantId}:{$group}:all";

        return Cache::remember($cacheKey, $this->cacheTtl, function () use ($tenantId, $group) {
            $settings = Setting::query()
                ->where('tenant_id', $tenantId)
                ->where('group', $group)
                ->get();

            $result = [];
            foreach ($settings as $setting) {
                $result[$setting->key] = $setting->decoded_value;
            }
            return $result;
        });
    }

    /**
     * Set multiple settings at once
     * 
     * @param string $group Setting group
     * @param array $settings Key-value pairs
     * @return void
     */
    public function setMany(string $group, array $settings): void
    {
        foreach ($settings as $key => $value) {
            $this->set($group, $key, $value);
        }
    }

    /**
     * Generate cache key
     * 
     * @param int|null $tenantId
     * @param string $group
     * @param string $key
     * @return string
     */
    protected function getCacheKey(?int $tenantId, string $group, string $key): string
    {
        return "settings:{$tenantId}:{$group}:{$key}";
    }

    /**
     * Check if a setting exists
     * 
     * @param string $group
     * @param string $key
     * @return bool
     */
    public function has(string $group, string $key): bool
    {
        $tenantId = tenant_id();

        return Setting::query()
            ->where('tenant_id', $tenantId)
            ->where('group', $group)
            ->where('key', $key)
            ->exists();
    }
}
