<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use App\Models\Warehouse;
use App\Models\Stock;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Get some dependencies
        $electronics = Category::where('name', 'Electronics')->first();
        $smartphones = Category::where('name', 'Smartphones')->first();
        $laptops = Category::where('name', 'Laptops')->first();
        $mainWarehouse = Warehouse::first();

        // 1. Create a Smartphone Product
        $iphone = Product::create([
            'product_name' => 'Super Phone 15',
            'sku' => 'SP-15-BASE',
            'price' => 12000000,
            'description' => 'Latest smartphone with amazing features.',
            'track_inventory' => true,
        ]);

        // Attach categories
        if ($smartphones) {
            $iphone->categories()->attach([$smartphones->id]);
        }
        
        // Initial Stock for base product in Main Warehouse
        if ($mainWarehouse) {
            Stock::create([
                'product_id' => $iphone->id,
                'warehouse_id' => $mainWarehouse->id,
                'stock_in' => 100,
                'current_stock' => 100,
                'minimum_stock' => 10,
            ]);
        }


        // 2. Create a Laptop Product with Variants
        $macbook = Product::create([
            'product_name' => 'Pro Laptop M3',
            'sku' => 'MB-PRO-M3',
            'price' => 25000000,
            'description' => 'Powerful laptop for professionals.',
            'track_inventory' => true,
        ]);

        if ($laptops) {
            $macbook->categories()->attach([$laptops->id]);
        }

        // Create Variants
        $variant1 = $macbook->variants()->create([
            'sku' => 'MB-PRO-M3-16GB',
            'price' => 25000000,
            'attributes' => ['ram' => '16GB', 'storage' => '512GB', 'color' => 'Space Grey'],
            'track_inventory' => true,
        ]);

        $variant2 = $macbook->variants()->create([
            'sku' => 'MB-PRO-M3-32GB',
            'price' => 30000000,
            'attributes' => ['ram' => '32GB', 'storage' => '1TB', 'color' => 'Silver'],
            'track_inventory' => true,
        ]);

        // Stock for Variants
        if ($mainWarehouse) {
            Stock::create([
                'product_id' => $macbook->id,
                'variant_id' => $variant1->id,
                'warehouse_id' => $mainWarehouse->id,
                'stock_in' => 20,
                'current_stock' => 20,
            ]);

            Stock::create([
                'product_id' => $macbook->id,
                'variant_id' => $variant2->id,
                'warehouse_id' => $mainWarehouse->id,
                'stock_in' => 15,
                'current_stock' => 15,
            ]);
        }

        // 3. Simple Product
        $mouse = Product::create([
            'product_name' => 'Wireless Mouse G1',
            'sku' => 'MOUSE-G1',
            'price' => 150000,
            'description' => 'Ergonomic wireless mouse.',
            'track_inventory' => true,
        ]);
        if($electronics) {
            $mouse->categories()->attach([$electronics->id]);
        }
        if ($mainWarehouse) {
             Stock::create([
                'product_id' => $mouse->id,
                'warehouse_id' => $mainWarehouse->id,
                'stock_in' => 500,
                'current_stock' => 500,
            ]);
        }
    }
}
