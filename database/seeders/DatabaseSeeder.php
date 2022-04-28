<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;



class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $this->call(shippingTypeTableSeeder::class);
         $this->call(orderStatusTableSeeder::class);
         $this->call(userRolesTableSeeder::class);
         $this->call(UserTableSeeder::class);
         $this->call(CategoryTableSeeder::class);
         $this->call(ProductTableSeeder::class);

        // $this->call('UsersTableSeeder');
    }
}
