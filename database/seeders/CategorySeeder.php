<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // Fashion categories for Manee Fashion Store
        $categories = [
            [
                'name' => 'Knitwear',
                'children' => [
                    'Sweaters',
                    'Cardigans',
                    'Pullovers',
                ]
            ],
            [
                'name' => 'Tops',
                'children' => [
                    'Blouses',
                    'T-Shirts',
                    'Shirts',
                    'Tank Tops',
                ]
            ],
            [
                'name' => 'Bottoms',
                'children' => [
                    'Pants',
                    'Skirts',
                    'Shorts',
                    'Jeans',
                ]
            ],
            [
                'name' => 'Dresses',
                'children' => [
                    'Casual Dresses',
                    'Evening Dresses',
                    'Maxi Dresses',
                ]
            ],
            [
                'name' => 'Accessories',
                'children' => [
                    'Scarves',
                    'Bags',
                    'Jewelry',
                ]
            ],
        ];

        foreach ($categories as $catData) {
            $parent = Category::firstOrCreate(
                ['slug' => Str::slug($catData['name'])],
                [
                    'name' => $catData['name'],
                    'is_active' => true,
                ]
            );

            foreach ($catData['children'] as $childName) {
                Category::firstOrCreate(
                    ['slug' => Str::slug($childName)],
                    [
                        'name' => $childName,
                        'parent_id' => $parent->id,
                        'is_active' => true,
                    ]
                );
            }
        }
    }
}
