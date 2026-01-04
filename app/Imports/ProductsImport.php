<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\Category;
use App\Models\Warehouse;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Row;

use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;

use App\Models\ImportHistory;

class ProductsImport implements ToCollection, WithHeadingRow
{
    private $primaryWarehouseId;
    private $importMode; // 'new' or 'update'
    private $importHistory;

    public function __construct($importMode = 'new', ImportHistory $importHistory = null)
    {
        $primary = Warehouse::where('is_primary', true)->first();
        // Fallback to first if no primary
        $this->primaryWarehouseId = $primary ? $primary->id : Warehouse::first()?->id;
        $this->importMode = $importMode;
        $this->importHistory = $importHistory;
    }

    public function collection(Collection $rows)
    {
        \Log::info('ProductsImport::collection called. Count: ' . $rows->count());
        
        $totalRows = $rows->count();
        $successfulRows = 0;
        $failedRows = 0;

        foreach ($rows as $row) 
        {
            $row = $row->toArray();
            \Log::info('Processing row: ' . json_encode($row));

            try {
                // Skip if Product Name is missing
                if (empty($row['product_name'])) {
                    \Log::warning('Row skipped: Missing product_name');
                    $failedRows++;
                    continue;
                }

                // Try to find by SKU first, then Name
                $product = null;
                if (!empty($row['sku'])) {
                    $product = Product::where('sku', $row['sku'])->first();
                }
                
                if (!$product) {
                    $product = Product::where('product_name', $row['product_name'])->first();
                }

                // Logic for Import Mode
                if ($this->importMode === 'new' && $product) {
                    \Log::info('Skipping existing product in NEW mode: ' . $row['product_name']);
                    // We can count this as successful (skipped) or just ignored. Let's count as successful processed.
                    $successfulRows++;
                    continue;
                }

                // Map labels
                $labels = isset($row['product_labels']) ? array_map('trim', explode(',', $row['product_labels'])) : [];
                $isNewArrival = in_array('New Arrival', $labels);
                $isBestSeller = in_array('Best Seller', $labels);
                $isOnSale = in_array('On Sale', $labels);

                $data = [
                    'product_name' => $row['product_name'],
                    'description' => $row['description'] ?? null,
                    'price' => $row['price'] ?? 0,
                    'sku' => $row['sku'] ?? null,
                    'barcode' => $row['barcode'] ?? null,
                    'track_inventory' => (isset($row['track_inventory']) && (strtolower($row['track_inventory']) === 'yes' || $row['track_inventory'] == 1)),
                    'is_new_arrival' => $isNewArrival,
                    'is_best_seller' => $isBestSeller,
                    'on_sale' => $isOnSale,
                ];

                if ($product) {
                    $product->update($data);
                    \Log::info('Updated product: ' . $product->product_name);
                } else {
                    $product = Product::create($data);
                    \Log::info('Created product: ' . $product->product_name);
                }

                // Handle Categories
                if (isset($row['categories'])) {
                    $categoryNames = array_map('trim', explode(',', $row['categories']));
                    $categoryIds = [];
                    foreach ($categoryNames as $name) {
                        if(empty($name)) continue;
                        $category = Category::firstOrCreate(['name' => $name], ['slug' => \Illuminate\Support\Str::slug($name)]);
                        $categoryIds[] = $category->id;
                    }
                    $product->categories()->sync($categoryIds);
                }

                // Handle Stock
                if (isset($row['stock']) && $product->track_inventory && $this->primaryWarehouseId) {
                    $qty = (int) $row['stock'];
                    $product->stocks()->updateOrCreate(
                        ['warehouse_id' => $this->primaryWarehouseId],
                        [
                            'current_stock' => $qty,
                            'stock_in' => $qty, // Simplified for import
                        ]
                    );
                }

                $successfulRows++;

            } catch (\Exception $e) {
                \Log::error('Row Failed: ' . $e->getMessage());
                $failedRows++;
            }
        }

        // Update History
        if ($this->importHistory) {
            $this->importHistory->update([
                'status' => $failedRows > 0 ? ($successfulRows > 0 ? 'completed' : 'failed') : 'completed', // Completed with warnings if some failed?
                'total_rows' => $totalRows,
                'successful_rows' => $successfulRows,
                'failed_rows' => $failedRows,
            ]);
        }
    }
}
