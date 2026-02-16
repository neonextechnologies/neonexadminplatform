<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

/**
 * ProductSeeder
 * 
 * Phase 7: Seed sample products for testing CRUD generator
 */
class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('🛍️ Seeding products...');

        $products = [
            ['name' => 'Laptop', 'price' => 35000, 'is_active' => true],
            ['name' => 'Smartphone', 'price' => 15000, 'is_active' => true],
            ['name' => 'Tablet', 'price' => 12000, 'is_active' => true],
            ['name' => 'Monitor', 'price' => 8000, 'is_active' => true],
            ['name' => 'Keyboard', 'price' => 1500, 'is_active' => true],
            ['name' => 'Mouse', 'price' => 800, 'is_active' => false],
            ['name' => 'Headphones', 'price' => 3500, 'is_active' => true],
            ['name' => 'Webcam', 'price' => 2500, 'is_active' => false],
        ];

        foreach ($products as $productData) {
            $product = Product::firstOrCreate(
                [
                    'name' => $productData['name'],
                    'tenant_id' => 1, // Default tenant
                ],
                [
                    'price' => $productData['price'],
                    'is_active' => $productData['is_active'],
                ]
            );

            if ($product->wasRecentlyCreated) {
                $this->command->info("  ✓ Created: {$product->name}");
                
                // Audit logging (Phase 7)
                audit()->record('product.created', $product);
            }
        }

        $this->command->info('✅ Products seeded successfully');
    }
}
