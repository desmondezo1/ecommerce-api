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
        $arr = [
            [
                "id"=> 1,
                "title" => "Covid-19",
                "parent_id" => null,
                "is_parent" => 0,
            ],
            [
                "id"=> 2,
                "title" => "Detergenza",
                "parent_id" => null,
                "is_parent" => 1,
            ],
            [
                "id"=> 3,
                "title" => "Detergenza",
                "parent_id" => null,
                "is_parent" => 1,
            ],
        ];
        $category = category::create([
            'title' => 'Category 1',
            'status' => 'published',
        ]);
    }
}
