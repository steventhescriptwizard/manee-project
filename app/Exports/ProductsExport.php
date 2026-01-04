<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProductsExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Product::with(['categories', 'stocks'])->get();
    }

    public function headings(): array
    {
        return [
            'Product Name',
            'Description',
            'Product Labels',
            'Categories',
            'Price',
            'SKU',
            'Barcode',
            'Track Inventory',
            'Stock',
        ];
    }

    public function map($product): array
    {
        $labels = [];
        if ($product->is_new_arrival) $labels[] = 'New Arrival';
        if ($product->is_best_seller) $labels[] = 'Best Seller';
        if ($product->on_sale) $labels[] = 'On Sale';

        return [
            $product->product_name,
            $product->description,
            implode(', ', $labels),
            $product->categories->pluck('name')->implode(', '),
            $product->price,
            $product->sku,
            $product->barcode,
            $product->track_inventory ? 'Yes' : 'No',
            $product->stocks->sum('current_stock'),
        ];
    }
}
