<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Warehouse;

class WarehouseSeeder extends Seeder
{
    public function run(): void
    {
        Warehouse::firstOrCreate(
            ['code' => 'WH-MAIN-001'],
            [
                'name' => 'Main Warehouse',
                'address' => '123 Utama Logistics St',
                'city' => 'Jakarta',
                'country' => 'Indonesia',
            ]
        );

        Warehouse::firstOrCreate(
            ['code' => 'WH-EAST-002'],
            [
                'name' => 'East Branch Hub',
                'address' => '456 East Side Rd',
                'city' => 'Surabaya',
                'country' => 'Indonesia',
            ]
        );
    }
}
