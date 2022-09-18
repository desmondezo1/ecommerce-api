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
        $pricing = [
            ['max_weight' => 2,'min_weight' => 0, 'price' => 5.67],
            ['max_weight' => 5,'min_weight' => 2.1, 'price' => 6.63],
            ['max_weight' => 10,'min_weight' => 5.1, 'price' => 7.10],
            ['max_weight' => 20,'min_weight' => 10.1, 'price' => 9.73],
            ['max_weight' => 30,'min_weight' => 20.1, 'price' => 15.38],
            ['max_weight' => 50,'min_weight' => 30.1, 'price' => 14.04],
            ['max_weight' => 70,'min_weight' => 50.1, 'price' => 26.92],
            ['max_weight' => 75,'min_weight' => 70.1, 'price' => 30.00],
            ['max_weight' => 100,'min_weight' => 75.1, 'price' => 31.73],
            ['max_weight' => 1000,'min_weight' => 100.1, 'price' => 28.00]
        ];

        foreach ($pricing  as $price){
            pricingTable::create($price);
        }
    }
}
