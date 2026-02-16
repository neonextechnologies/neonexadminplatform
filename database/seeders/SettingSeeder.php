<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

/**
 * SettingSeeder
 * 
 * Phase 4: Seeds default application settings
 * Audit-first: Logs all setting creation
 */
class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('🔧 Seeding default settings...');

        // Default application settings
        $defaultSettings = [
            'app' => [
                'site_name' => 'NeonEx Admin Platform',
                'site_description' => 'Modern Admin Platform with Multi-tenancy',
                'timezone' => 'Asia/Bangkok',
                'date_format' => 'Y-m-d',
                'time_format' => 'H:i:s',
                'items_per_page' => 25,
                'maintenance_mode' => false,
            ],
            'theme' => [
                'active' => 'plain',
                'primary_color' => '#0d6efd',
                'sidebar_collapsed' => false,
            ],
            'mail' => [
                'from_name' => 'NeonEx Admin',
                'from_email' => 'noreply@neonex.test',
            ],
            'security' => [
                'password_min_length' => 8,
                'session_lifetime' => 120,
                'require_email_verification' => false,
            ],
        ];

        $settingsCount = 0;

        foreach ($defaultSettings as $group => $settings) {
            foreach ($settings as $key => $value) {
                // Use SettingService to set values (with audit logging)
                setting()->set($group, $key, $value);
                $settingsCount++;
            }
            
            $this->command->info("  ✅ {$group}: " . count($settings) . " settings");
        }

        $this->command->info("✅ Total settings seeded: {$settingsCount}");
        
        // Audit-first: Log seeding completion
        logger()->info('Settings seeded', [
            'count' => $settingsCount,
            'groups' => array_keys($defaultSettings),
        ]);
    }
}
