<?php

namespace App\Services;

use App\Contracts\PermissionRegistryContract;
use App\Models\Permission;
use Illuminate\Support\Facades\Cache;

/**
 * Permission Registry Service
 * 
 * Phase 2: Registry-first implementation
 * ALL permissions MUST be registered here before use
 * 
 * This service ensures:
 * - Permissions are centrally managed
 * - Permissions are synced to database
 * - Permissions are cached for performance
 */
class PermissionRegistry implements PermissionRegistryContract
{
    /**
     * Registered permissions storage
     *
     * @var array
     */
    protected array $permissions = [];

    /**
     * Cache key for registered permissions
     *
     * @var string
     */
    protected string $cacheKey = 'permissions.registry';

    /**
     * Register a permission with the system
     *
     * @param string $name Permission name (e.g., 'users.view')
     * @param string $group Permission group (e.g., 'Users')
     * @param string|null $description Optional description
     * @return void
     */
    public function register(string $name, string $group, ?string $description = null): void
    {
        $this->permissions[$name] = [
            'name' => $name,
            'group' => $group,
            'label' => $this->generateLabel($name),
            'description' => $description,
        ];
    }

    /**
     * Register multiple permissions at once
     *
     * @param array $permissions Array of [name => [group, description]]
     * @return void
     */
    public function registerMany(array $permissions): void
    {
        foreach ($permissions as $name => $data) {
            $this->register(
                $name,
                $data['group'] ?? 'general',
                $data['description'] ?? null
            );
        }
    }

    /**
     * Check if a permission is registered
     *
     * @param string $name
     * @return bool
     */
    public function has(string $name): bool
    {
        return isset($this->permissions[$name]);
    }

    /**
     * Get all registered permissions
     *
     * @return array
     */
    public function all(): array
    {
        return $this->permissions;
    }

    /**
     * Get permissions by group
     *
     * @param string $group
     * @return array
     */
    public function byGroup(string $group): array
    {
        return array_filter($this->permissions, function ($permission) use ($group) {
            return $permission['group'] === $group;
        });
    }

    /**
     * Sync registered permissions to database
     * 
     * This should be called during deployment or seeding
     * Registry-first: Only registered permissions will exist in DB
     *
     * @return array Statistics about sync operation
     */
    public function syncToDatabase(): array
    {
        $stats = [
            'created' => 0,
            'updated' => 0,
            'deleted' => 0,
        ];

        $registeredNames = array_keys($this->permissions);

        // Create or update registered permissions
        foreach ($this->permissions as $name => $data) {
            $permission = Permission::updateOrCreate(
                ['name' => $name],
                [
                    'group' => $data['group'],
                    'label' => $data['label'],
                    'description' => $data['description'],
                ]
            );

            if ($permission->wasRecentlyCreated) {
                $stats['created']++;
                // Audit log
                logger()->info('Permission registered', [
                    'permission' => $name,
                    'group' => $data['group'],
                ]);
            } else {
                $stats['updated']++;
            }
        }

        // Delete permissions that are no longer registered (optional - can be disabled for safety)
        // $deleted = Permission::whereNotIn('name', $registeredNames)->delete();
        // $stats['deleted'] = $deleted;

        // Clear cache
        Cache::forget($this->cacheKey);

        return $stats;
    }

    /**
     * Generate human-readable label from permission name
     *
     * @param string $name
     * @return string
     */
    protected function generateLabel(string $name): string
    {
        // Convert "users.view" to "View Users"
        $parts = explode('.', $name);
        
        if (count($parts) === 2) {
            $action = ucfirst($parts[1]);
            $resource = ucfirst($parts[0]);
            return "{$action} {$resource}";
        }

        return ucwords(str_replace(['.', '_', '-'], ' ', $name));
    }

    /**
     * Get all groups
     *
     * @return array
     */
    public function getGroups(): array
    {
        return array_unique(array_column($this->permissions, 'group'));
    }
}
