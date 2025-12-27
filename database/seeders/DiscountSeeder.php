<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Discount;

class DiscountSeeder extends Seeder
{
    public function run(): void
    {
        Discount::create([
            'discount_name' => 'Grand Opening Sale',
            'discount_type' => 'PERCENT',
            'discount_value' => 10.00,
            'start_date' => now(),
            'end_date' => now()->addMonth(),
            'is_active' => true,
        ]);

        Discount::create([
            'discount_name' => 'Flash Sale 50k Off',
            'discount_type' => 'FIXED',
            'discount_value' => 50000.00,
            'start_date' => now(),
            'end_date' => now()->addDays(7),
            'is_active' => true,
            'min_purchase' => 200000.00,
        ]);
    }
}
