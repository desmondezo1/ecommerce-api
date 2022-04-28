<?php

namespace Database\Seeders;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'first_name' => 'Desmond',
            'last_name' => 'Ezo-Ojile',
            'email' => 'desmondezoojile@gmail.com',
            'phone' => '08162099369',
            'password' => Hash::make('password123'),
            'role' => 4
        ]);

        $user = User::create([
            'first_name' => 'Desmond',
            'last_name' => 'Ezo-Ojile',
            'email' => 'desezo@gmail.com',
            'phone' => '08162099364',
            'password' => Hash::make('password123'),
            'role' => 1
        ]);
    }
}
