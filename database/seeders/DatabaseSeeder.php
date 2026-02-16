<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

/**
 * Database Seeder
 * 
 * Phase 1: Seeds basic users
 * Phase 2+: Will add role/permission seeders
 */
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Phase 2: RBAC seeders (registry-first: permissions MUST be seeded first)
        $this->call([
            PermissionSeeder::class,  // Registry-first: Register permissions
            RoleSeeder::class,         // Create roles + assign permissions
            UserSeeder::class,         // Create users + assign roles
        ]);
    }
}
