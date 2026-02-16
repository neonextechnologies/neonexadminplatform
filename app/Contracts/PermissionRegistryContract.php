<?php

namespace App\Contracts;

/**
 * Permission Registry Contract
 * 
 * Central registry for permission definitions (registry-first approach)
 * All permissions MUST be registered through this contract.
 * 
 * Layer A: Contract only (implementations in Phase 2+)
 */
interface PermissionRegistryContract
{
    /**
     * Register a permission with the system
     * 
     * @param string $name Permission name (e.g., 'users.view')
     * @param string $group Permission group (e.g., 'Users')
     * @param string|null $description Optional description
     * @return void
     */
    public function register(string $name, string $group, ?string $description = null): void;

    /**
     * Register multiple permissions at once
     * 
     * @param array $permissions Array of [name => [group, description]]
     * @return void
     */
    public function registerMany(array $permissions): void;

    /**
     * Check if a permission is registered
     * 
     * @param string $name
     * @return bool
     */
    public function has(string $name): bool;

    /**
     * Get all registered permissions
     * 
     * @return array
     */
    public function all(): array;

    /**
     * Get permissions by group
     * 
     * @param string $group
     * @return array
     */
    public function byGroup(string $group): array;
}
