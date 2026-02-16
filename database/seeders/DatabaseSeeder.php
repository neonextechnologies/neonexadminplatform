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
        // Phase 2-5: Kernel seeders
        $this->call([
            PermissionSeeder::class,  // Phase 2: Registry-first - Register permissions
            RoleSeeder::class,         // Phase 2: Create roles + assign permissions
            UserSeeder::class,         // Phase 2: Create users + assign roles
            SettingSeeder::class,      // Phase 4: Seed default settings (audit-first)
            TenantSeeder::class,       // Phase 5: Seed tenants + domains (audit-first)
            ProductSeeder::class,      // Phase 7: Sample products for CRUD generator
        ]);
    }
}
