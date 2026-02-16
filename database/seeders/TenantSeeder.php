<?php

namespace Database\Seeders;

use App\Models\Tenant;
use App\Models\TenantDomain;
use App\Models\User;
use Illuminate\Database\Seeder;

/**
 * TenantSeeder
 * 
 * Phase 5: Seeds default tenants and tenant domains
 * Audit-first: Logs all tenant creation
 */
class TenantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('🏢 Seeding tenants...');

        // Create default tenant
        $defaultTenant = Tenant::firstOrCreate(
            ['slug' => 'default'],
            [
                'name' => 'Default Tenant',
                'is_active' => true,
            ]
        );

        if ($defaultTenant->wasRecentlyCreated) {
            $this->command->info('  ✅ Created: Default Tenant');
            
            // Audit-first: Log tenant creation
            audit()->record('tenants.created', $defaultTenant, [
                'name' => $defaultTenant->name,
                'slug' => $defaultTenant->slug,
            ]);
        } else {
            $this->command->info('  ⚠️  Default Tenant already exists');
        }

        // Create tenant domain for path-based access: /t/default
        $pathDomain = TenantDomain::firstOrCreate(
            ['path' => '/t/default'],
            [
                'tenant_id' => $defaultTenant->id,
                'domain' => null,
                'subdomain' => null,
            ]
        );

        if ($pathDomain->wasRecentlyCreated) {
            $this->command->info('  ✅ Created domain: /t/default (path-based)');
        }

        // Create tenant domain for full domain (optional, for production)
        // Uncomment if you have a custom domain
        // $domainEntry = TenantDomain::firstOrCreate(
        //     ['domain' => 'neonexadminplatform.test'],
        //     [
        //         'tenant_id' => $defaultTenant->id,
        //         'subdomain' => null,
        //         'path' => null,
        //     ]
        // );

        // Associate all existing users with default tenant
        $users = User::all();
        foreach ($users as $user) {
            if (!$defaultTenant->hasUser($user->id)) {
                $defaultTenant->addUser($user->id);
                $this->command->info("  ✅ Associated user: {$user->email}");
            }
        }

        // Create demo tenant for testing
        $demoTenant = Tenant::firstOrCreate(
            ['slug' => 'demo'],
            [
                'name' => 'Demo Tenant',
                'is_active' => true,
            ]
        );

        if ($demoTenant->wasRecentlyCreated) {
            $this->command->info('  ✅ Created: Demo Tenant');
            
            // Audit-first: Log tenant creation
            audit()->record('tenants.created', $demoTenant, [
                'name' => $demoTenant->name,
                'slug' => $demoTenant->slug,
            ]);
        }

        // Create tenant domain for demo: /t/demo
        $demoDomain = TenantDomain::firstOrCreate(
            ['path' => '/t/demo'],
            [
                'tenant_id' => $demoTenant->id,
                'domain' => null,
                'subdomain' => null,
            ]
        );

        if ($demoDomain->wasRecentlyCreated) {
            $this->command->info('  ✅ Created domain: /t/demo (path-based)');
        }

        $this->command->info('✅ Tenants seeded successfully');
        
        // Audit-first: Log seeding completion
        logger()->info('Tenants seeded', [
            'tenants_count' => Tenant::count(),
            'domains_count' => TenantDomain::count(),
        ]);
    }
}
