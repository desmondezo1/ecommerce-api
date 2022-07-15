<?php

namespace Database\Seeders;

use App\Models\pricingTable;
use Illuminate\Database\Seeder;

class pricingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles =  ['max_weight' => 20,'min_weight' => 10, 'price' => 5];
        pricingTable::create($roles);
    }
}
