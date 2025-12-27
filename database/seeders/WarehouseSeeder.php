<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Warehouse;

class WarehouseSeeder extends Seeder
{
    public function run(): void
    {
        Warehouse::create([
            'name' => 'Main Warehouse',
            'code' => 'WH-MAIN-001',
            'address' => '123 Utama Logistics St',
            'city' => 'Jakarta',
            'country' => 'Indonesia',
        ]);

        Warehouse::create([
            'name' => 'East Branch Hub',
            'code' => 'WH-EAST-002',
            'address' => '456 East Side Rd',
            'city' => 'Surabaya',
            'country' => 'Indonesia',
        ]);
    }
}
