<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use App\Models\Warehouse;
use App\Models\Stock;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Get categories
        $knitwear = Category::where('name', 'Knitwear')->first();
        $sweaters = Category::where('name', 'Sweaters')->first();
        $tops = Category::where('name', 'Tops')->first();
        $blouses = Category::where('name', 'Blouses')->first();
        $bottoms = Category::where('name', 'Bottoms')->first();
        $pants = Category::where('name', 'Pants')->first();
        $dresses = Category::where('name', 'Dresses')->first();
        
        $mainWarehouse = Warehouse::first();

        // 1. Cashmere Sweater
        $product1 = Product::firstOrCreate(
            ['sku' => 'MN-SW-001'],
            [
                'product_name' => 'Cashmere Classic Sweater',
                'price' => 1250000,
                'description' => 'Luxurious cashmere sweater with elegant ribbed details. Perfect for any occasion.',
                'track_inventory' => true,
            ]
        );
        if ($sweaters) $product1->categories()->syncWithoutDetaching([$sweaters->id]);
        if ($knitwear) $product1->categories()->syncWithoutDetaching([$knitwear->id]);
        $this->createStock($product1, $mainWarehouse, 50);

        // 2. Silk Blouse
        $product2 = Product::firstOrCreate(
            ['sku' => 'MN-BL-001'],
            [
                'product_name' => 'Silk Elegance Blouse',
                'price' => 850000,
                'description' => 'Premium silk blouse with delicate button details. Timeless elegance for the modern woman.',
                'track_inventory' => true,
            ]
        );
        if ($blouses) $product2->categories()->syncWithoutDetaching([$blouses->id]);
        if ($tops) $product2->categories()->syncWithoutDetaching([$tops->id]);
        $this->createStock($product2, $mainWarehouse, 75);

        // 3. Wide Leg Pants
        $product3 = Product::firstOrCreate(
            ['sku' => 'MN-PT-001'],
            [
                'product_name' => 'Wide Leg Tailored Pants',
                'price' => 950000,
                'description' => 'Sophisticated wide leg pants with perfect drape. High-waisted design for a flattering silhouette.',
                'track_inventory' => true,
            ]
        );
        if ($pants) $product3->categories()->syncWithoutDetaching([$pants->id]);
        if ($bottoms) $product3->categories()->syncWithoutDetaching([$bottoms->id]);
        $this->createStock($product3, $mainWarehouse, 60);

        // 4. Knit Cardigan
        $product4 = Product::firstOrCreate(
            ['sku' => 'MN-CD-001'],
            [
                'product_name' => 'Oversized Knit Cardigan',
                'price' => 780000,
                'description' => 'Cozy oversized cardigan in soft wool blend. Perfect layering piece for transitional weather.',
                'track_inventory' => true,
            ]
        );
        if ($knitwear) $product4->categories()->syncWithoutDetaching([$knitwear->id]);
        $this->createStock($product4, $mainWarehouse, 45);

        // 5. Evening Dress
        $product5 = Product::firstOrCreate(
            ['sku' => 'MN-DR-001'],
            [
                'product_name' => 'Velvet Evening Gown',
                'price' => 2500000,
                'description' => 'Stunning velvet evening gown with elegant draping. Make a statement at any formal event.',
                'track_inventory' => true,
            ]
        );
        if ($dresses) $product5->categories()->syncWithoutDetaching([$dresses->id]);
        $this->createStock($product5, $mainWarehouse, 25);

        // 6. Cotton T-Shirt
        $product6 = Product::firstOrCreate(
            ['sku' => 'MN-TS-001'],
            [
                'product_name' => 'Premium Cotton T-Shirt',
                'price' => 350000,
                'description' => 'Essential wardrobe staple in premium organic cotton. Relaxed fit with refined details.',
                'track_inventory' => true,
            ]
        );
        if ($tops) $product6->categories()->syncWithoutDetaching([$tops->id]);
        $this->createStock($product6, $mainWarehouse, 100);
    }

    private function createStock($product, $warehouse, $quantity)
    {
        if (!$warehouse) return;
        
        Stock::firstOrCreate(
            [
                'product_id' => $product->id,
                'warehouse_id' => $warehouse->id,
            ],
            [
                'stock_in' => $quantity,
                'current_stock' => $quantity,
                'minimum_stock' => 10,
            ]
        );
    }
}
