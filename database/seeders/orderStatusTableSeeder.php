<?php

namespace Database\Seeders;

use App\Models\order_status;
use Illuminate\Database\Seeder;

class orderStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $statuses = [
                        ['status' => 'PENDING_APPROVAL'],
                        ['status' => 'AWAITING_PAYMENT'],
                        ['status' => 'PROCESSING'],
                        ['status' => 'SHIPPED'],
                        ['status' => 'CANCELED'],
                        ['status' => 'REJECTED'],
                        ['status' => 'COMPLETED'],
                    ];

        foreach ($statuses as $status){
            order_status::create($status);
        }

    }
}
