<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Electronics',
                'children' => [
                    'Smartphones',
                    'Laptops',
                    'Tablets',
                    'Accessories',
                ]
            ],
            [
                'name' => 'Fashion',
                'children' => [
                    'Men',
                    'Women',
                    'Kids',
                ]
            ],
            [
                'name' => 'Home & Living',
                'children' => [
                    'Furniture',
                    'Decor',
                    'Lighting',
                ]
            ]
        ];

        foreach ($categories as $catData) {
            $parent = Category::create([
                'name' => $catData['name'],
                'slug' => Str::slug($catData['name']),
                'is_active' => true,
            ]);

            foreach ($catData['children'] as $childName) {
                Category::create([
                    'name' => $childName,
                    'slug' => Str::slug($childName),
                    'parent_id' => $parent->id,
                    'is_active' => true,
                ]);
            }
        }
    }
}
