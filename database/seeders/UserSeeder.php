<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * User Seeder
 * 
 * Phase 1: Seeds default admin user for testing
 * Phase 2: Assigns roles to users (RBAC)
 * Audit-first: Logs user creation (via model events or explicit logging)
 */
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user if not exists
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        if ($admin->wasRecentlyCreated) {
            // Audit-first: Log admin user creation
            logger()->info('Admin user seeded', [
                'user_id' => $admin->id,
                'email' => $admin->email,
                'name' => $admin->name,
            ]);

            $this->command->info('✅ Admin user created: admin@example.com / password');
        } else {
            $this->command->info('⚠️  Admin user already exists');
        }

        // Phase 2: Assign admin role
        $adminRole = Role::where('name', 'admin')->first();
        if ($adminRole && !$admin->hasRole('admin')) {
            $admin->assignRole($adminRole);
            $this->command->info('  → Assigned admin role');
            
            // Audit-first: Log role assignment
            logger()->info('Role assigned to user', [
                'user_id' => $admin->id,
                'role' => 'admin',
            ]);
        }

        // Create test user if not exists
        $testUser = User::firstOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'Test User',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        if ($testUser->wasRecentlyCreated) {
            // Audit-first: Log test user creation
            logger()->info('Test user seeded', [
                'user_id' => $testUser->id,
                'email' => $testUser->email,
                'name' => $testUser->name,
            ]);

            $this->command->info('✅ Test user created: user@example.com / password');
        } else {
            $this->command->info('⚠️  Test user already exists');
        }

        // Phase 2: Assign user role
        $userRole = Role::where('name', 'user')->first();
        if ($userRole && !$testUser->hasRole('user')) {
            $testUser->assignRole($userRole);
            $this->command->info('  → Assigned user role');
            
            // Audit-first: Log role assignment
            logger()->info('Role assigned to user', [
                'user_id' => $testUser->id,
                'role' => 'user',
            ]);
        }
    }
}
