<?php

namespace Database\Seeders;

use App\Models\category;
use Illuminate\Database\Seeder;


class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category = category::create([
            'title' => 'Category 1',
            'status' => 'published',
        ]);
    }
}
