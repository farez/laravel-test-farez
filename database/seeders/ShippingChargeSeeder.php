<?php

namespace Database\Seeders;

use App\Models\Sale;
use App\Models\ShippingCharge;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShippingChargeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ShippingCharge::factory()->create([
            'cost' => 10.00,
            'number_of_sales' => Sale::all()->count(),
        ]);
    }
}
