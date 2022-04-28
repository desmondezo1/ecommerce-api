<?php

namespace Database\Seeders;

use App\Models\shipping_type;
use Illuminate\Database\Seeder;

class shippingTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            ['type' => 'Pick-up Station'],
            ['type' => 'Door Delivery'],
        ];

        foreach ($roles as $role){
            shipping_type::create($role);
        }
    }
}
