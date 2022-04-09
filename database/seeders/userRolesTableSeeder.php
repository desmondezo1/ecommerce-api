<?php

namespace Database\Seeders;

use App\Models\user_role;
use Illuminate\Database\Seeder;

class userRolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
            $roles = [
                ['role' => 'SHOPPER'],
                ['role' => 'ADMIN'],
                ['role' => 'PARTNER'],
                ['role' => 'SUPER_ADMIN'],
            ];

            foreach ($roles as $role){
                user_role::create($role);
            }
    }

}
