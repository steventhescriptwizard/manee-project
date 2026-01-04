<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Collection;

class ProductTemplateExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // Return an empty collection or a single example row
        return new Collection([
            [
                'Example Product',
                'This is an example description',
                'New Arrival, Best Seller',
                'Tops, Women',
                '150000',
                'EX-001',
                '123456789',
                'Yes',
                '100'
            ]
        ]);
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
}
