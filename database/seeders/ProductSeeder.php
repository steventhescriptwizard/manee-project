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
        // Get categories
        $knitwear = Category::where('name', 'Knitwear')->first();
        $tops = Category::where('name', 'Tops')->first();
        $bottoms = Category::where('name', 'Bottoms')->first();
        $mainWarehouse = Warehouse::first();

        // 1. Knitwear Product - Oversized Sweater with variants
        $sweater = Product::create([
            'product_name' => 'Oversized Knit Sweater',
            'sku' => 'KNT-SWT-001',
            'price' => 450000,
            'description' => 'Cozy oversized knit sweater perfect for layering. Made from premium cotton blend.',
            'track_inventory' => true,
        ]);

        if ($knitwear) {
            $sweater->categories()->attach([$knitwear->id]);
        }

        // Create color/size variants for sweater
        $sweaterBeige = $sweater->variants()->create([
            'sku' => 'KNT-SWT-001-BEIGE-M',
            'price' => 450000,
            'color' => 'Beige',
            'size' => 'M',
            'track_inventory' => true,
        ]);

        $sweaterBeigeLarge = $sweater->variants()->create([
            'sku' => 'KNT-SWT-001-BEIGE-L',
            'price' => 450000,
            'color' => 'Beige',
            'size' => 'L',
            'track_inventory' => true,
        ]);

        $sweaterGrey = $sweater->variants()->create([
            'sku' => 'KNT-SWT-001-GREY-M',
            'price' => 450000,
            'color' => 'Grey',
            'size' => 'M',
            'track_inventory' => true,
        ]);

        // Stock for sweater variants
        if ($mainWarehouse) {
            Stock::create([
                'product_id' => $sweater->id,
                'variant_id' => $sweaterBeige->id,
                'warehouse_id' => $mainWarehouse->id,
                'stock_in' => 30,
                'current_stock' => 30,
                'minimum_stock' => 5,
            ]);

            Stock::create([
                'product_id' => $sweater->id,
                'variant_id' => $sweaterBeigeLarge->id,
                'warehouse_id' => $mainWarehouse->id,
                'stock_in' => 25,
                'current_stock' => 25,
                'minimum_stock' => 5,
            ]);

            Stock::create([
                'product_id' => $sweater->id,
                'variant_id' => $sweaterGrey->id,
                'warehouse_id' => $mainWarehouse->id,
                'stock_in' => 20,
                'current_stock' => 20,
                'minimum_stock' => 5,
            ]);
        }

        // 2. Tops Product - Classic White Shirt
        $shirt = Product::create([
            'product_name' => 'Classic White Shirt',
            'sku' => 'TOP-SHT-001',
            'price' => 299000,
            'description' => 'Timeless white button-up shirt. Perfect for any occasion.',
            'track_inventory' => true,
        ]);

        if ($tops) {
            $shirt->categories()->attach([$tops->id]);
        }

        // Variants for shirt
        $shirtS = $shirt->variants()->create([
            'sku' => 'TOP-SHT-001-WHITE-S',
            'price' => 299000,
            'color' => 'White',
            'size' => 'S',
            'track_inventory' => true,
        ]);

        $shirtM = $shirt->variants()->create([
            'sku' => 'TOP-SHT-001-WHITE-M',
            'price' => 299000,
            'color' => 'White',
            'size' => 'M',
            'track_inventory' => true,
        ]);

        if ($mainWarehouse) {
            Stock::create([
                'product_id' => $shirt->id,
                'variant_id' => $shirtS->id,
                'warehouse_id' => $mainWarehouse->id,
                'stock_in' => 40,
                'current_stock' => 40,
                'minimum_stock' => 10,
            ]);

            Stock::create([
                'product_id' => $shirt->id,
                'variant_id' => $shirtM->id,
                'warehouse_id' => $mainWarehouse->id,
                'stock_in' => 50,
                'current_stock' => 50,
                'minimum_stock' => 10,
            ]);
        }

        // 3. Bottoms Product - Wide Leg Trousers
        $trousers = Product::create([
            'product_name' => 'Wide Leg Trousers',
            'sku' => 'BTM-TRS-001',
            'price' => 550000,
            'description' => 'Elegant wide leg trousers with high waist. Comfortable and stylish.',
            'track_inventory' => true,
        ]);

        if ($bottoms) {
            $trousers->categories()->attach([$bottoms->id]);
        }

        // Variants for trousers
        $trousersBlack = $trousers->variants()->create([
            'sku' => 'BTM-TRS-001-BLACK-M',
            'price' => 550000,
            'color' => 'Black',
            'size' => 'M',
            'track_inventory' => true,
        ]);

        $trousersNavy = $trousers->variants()->create([
            'sku' => 'BTM-TRS-001-NAVY-M',
            'price' => 550000,
            'color' => 'Navy',
            'size' => 'M',
            'track_inventory' => true,
        ]);

        if ($mainWarehouse) {
            Stock::create([
                'product_id' => $trousers->id,
                'variant_id' => $trousersBlack->id,
                'warehouse_id' => $mainWarehouse->id,
                'stock_in' => 35,
                'current_stock' => 35,
                'minimum_stock' => 8,
            ]);

            Stock::create([
                'product_id' => $trousers->id,
                'variant_id' => $trousersNavy->id,
                'warehouse_id' => $mainWarehouse->id,
                'stock_in' => 30,
                'current_stock' => 30,
                'minimum_stock' => 8,
            ]);
        }
    }
}
