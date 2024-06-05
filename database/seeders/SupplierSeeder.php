<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Supplier;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Supplier::factory()
            ->count(30)
            ->hasOrders(15)
            ->create();

        Supplier::factory()
            ->count(200)
            ->hasOrders(2)
            ->create();

        Supplier::factory()
            ->count(50)
            ->hasOrders(1)
            ->create();

        Supplier::factory()
            ->count(10)
            ->create();
    }
}
