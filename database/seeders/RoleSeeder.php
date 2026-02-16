<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

/**
 * Role Seeder
 * 
 * Phase 2: Creates baseline roles and assigns permissions
 * Audit-first: Logs role creation
 */
class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('👥 Creating roles...');

        // Create Admin role (full permissions)
        $admin = $this->createRole(
            'admin',
            'Administrator',
            'Full system access'
        );
        $this->assignAllPermissions($admin);

        // Create User role (limited permissions)
        $user = $this->createRole(
            'user',
            'User',
            'Regular user with limited access'
        );
        $this->assignUserPermissions($user);

        // Create Guest role (minimal permissions)
        $guest = $this->createRole(
            'guest',
            'Guest',
            'Guest user with read-only access'
        );
        $this->assignGuestPermissions($guest);

        $this->command->info('✅ Roles created successfully');
    }

    /**
     * Create a role
     */
    protected function createRole(string $name, string $label, string $description): Role
    {
        $role = Role::firstOrCreate(
            ['name' => $name],
            [
                'label' => $label,
                'description' => $description,
            ]
        );

        if ($role->wasRecentlyCreated) {
            // Audit-first: Log role creation
            logger()->info('Role created', [
                'role_name' => $name,
                'role_label' => $label,
            ]);

            $this->command->info("  ✓ Role created: {$label}");
        } else {
            $this->command->info("  ⚠ Role exists: {$label}");
        }

        return $role;
    }

    /**
     * Assign all permissions to a role (for admin)
     */
    protected function assignAllPermissions(Role $role): void
    {
        $permissions = Permission::all();
        $role->permissions()->syncWithoutDetaching($permissions->pluck('id'));

        $this->command->info("    → Assigned {$permissions->count()} permissions to {$role->label}");

        // Audit-first: Log permission assignment
        logger()->info('All permissions assigned to role', [
            'role_name' => $role->name,
            'permission_count' => $permissions->count(),
        ]);
    }

    /**
     * Assign user-level permissions
     */
    protected function assignUserPermissions(Role $role): void
    {
        $permissionNames = [
            'auth.login',
            'auth.logout',
            'users.view',
        ];

        $permissions = Permission::whereIn('name', $permissionNames)->get();
        $role->permissions()->syncWithoutDetaching($permissions->pluck('id'));

        $this->command->info("    → Assigned {$permissions->count()} permissions to {$role->label}");

        // Audit-first: Log permission assignment
        logger()->info('User permissions assigned to role', [
            'role_name' => $role->name,
            'permissions' => $permissionNames,
        ]);
    }

    /**
     * Assign guest-level permissions
     */
    protected function assignGuestPermissions(Role $role): void
    {
        $permissionNames = [
            'auth.login',
            'auth.logout',
        ];

        $permissions = Permission::whereIn('name', $permissionNames)->get();
        $role->permissions()->syncWithoutDetaching($permissions->pluck('id'));

        $this->command->info("    → Assigned {$permissions->count()} permissions to {$role->label}");

        // Audit-first: Log permission assignment
        logger()->info('Guest permissions assigned to role', [
            'role_name' => $role->name,
            'permissions' => $permissionNames,
        ]);
    }
}
