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
                "title" => "KIT E OFFERTE",
                "parent_id" => null,
                "is_parent" => 0,
            ],
            [
                "id"=> 3,
                "title" => "Detergenza",
                "parent_id" => null,
                "is_parent" => 1,
            ],
                [
                    "id"=> 11,
                    "title" => "Cucina",
                    "parent_id" => 3,
                    "is_parent" => 1,
                ],
                        [
                            "id"=> 21,
                            "title" => "Stoviglie",
                            "parent_id" => 11,
                            "is_parent" => 1,
                        ],
                                [
                                    "id"=> 28,
                                    "title" => "Detergente Lavaggio Manuale",
                                    "parent_id" => 21,
                                    "is_parent" => 0,
                                ],[
                                    "id"=> 29,
                                    "title" => "Detergente Lavastoviglie",
                                    "parent_id" => 21,
                                    "is_parent" => 0,
                                ],[
                                    "id"=> 30,
                                    "title" => "Brillantante Lavastoviglie",
                                    "parent_id" => 21,
                                    "is_parent" => 0,
                                ],
                        [
                            "id"=> 22,
                            "title" => "Sgrassatori",
                            "parent_id" => 11,
                            "is_parent" => 0,
                        ],[
                            "id"=> 23,
                            "title" => "Sanificanti",
                            "parent_id" => 11,
                            "is_parent" => 0,
                        ],[
                            "id"=> 24,
                            "title" => "Lucidanti Acciaio",
                            "parent_id" => 11,
                            "is_parent" => 0,
                        ],[
                            "id"=> 25,
                            "title" => "Multiuso",
                            "parent_id" => 11,
                            "is_parent" => 0,
                        ],[
                            "id"=> 26,
                            "title" => "Pulizia di fondo",
                            "parent_id" => 11,
                            "is_parent" => 0,
                        ],[
                            "id"=> 27,
                            "title" => "Disgorganti",
                            "parent_id" => 11,
                            "is_parent" => 0,
                        ],
                [
                    "id"=> 12,
                    "title" => "Bagno",
                    "parent_id" => 3,
                    "is_parent" => 1,
                ],
                        [
                            "id"=> 31,
                            "title" => "Pulizia Quotidiana",
                            "parent_id" => 12,
                            "is_parent" => 0,
                        ],[
                            "id"=> 32,
                            "title" => "Anticalcare e Disincrostanti",
                            "parent_id" => 12,
                            "is_parent" => 0,
                        ],[
                            "id"=> 33,
                            "title" => "WC",
                            "parent_id" => 12,
                            "is_parent" => 0,
                        ],[
                            "id"=> 34,
                            "title" => "Sanificanti",
                            "parent_id" => 12,
                            "is_parent" => 0,
                        ],[
                            "id"=> 35,
                            "title" => "Disgorganti",
                            "parent_id" => 12,
                            "is_parent" => 0,
                        ],
                [
                    "id"=> 13,
                    "title" => "Pavimenti",
                    "parent_id" => 3,
                    "is_parent" => 1,
                ],
                        [
                            "id"=> 36,
                            "title" => "Manutentori",
                            "parent_id" => 13,
                            "is_parent" => 0,
                        ],
                        [
                            "id"=> 37,
                            "title" => "Sgrassanti",
                            "parent_id" => 13,
                            "is_parent" => 0,
                        ],[
                            "id"=> 38,
                            "title" => "Sanificanti",
                            "parent_id" => 13,
                            "is_parent" => 0,
                        ],[
                            "id"=> 39,
                            "title" => "Pulizia di Fondo",
                            "parent_id" => 13,
                            "is_parent" => 0,
                        ],
                [
                    "id"=> 14,
                    "title" => "Mobili e Vetri",
                    "parent_id" => 3,
                    "is_parent" => 0,
                ],
                [
                    "id"=> 15,
                    "title" => "Deodoranti",
                    "parent_id" => 3,
                    "is_parent" => 0,
                ],
                [
                    "id"=> 16,
                    "title" => "Mani",
                    "parent_id" => 3,
                    "is_parent" => 1,
                ],
                        [
                            "id"=> 40,
                            "title" => "Liquido",
                            "parent_id" => 16,
                            "is_parent" => 0,
                        ],[
                            "id"=> 41,
                            "title" => "Schiuma",
                            "parent_id" => 16,
                            "is_parent" => 0,
                        ],[
                            "id"=> 42,
                            "title" => "Pasta Lavamani",
                            "parent_id" => 16,
                            "is_parent" => 0,
                        ],
                [
                    "id"=> 17,
                    "title" => "Lavanderia",
                    "parent_id" => 3,
                    "is_parent" => 0,
                ],
                [
                    "id"=> 18,
                    "title" => "Piscina",
                    "parent_id" => 3,
                    "is_parent" => 0,
                ],
                [
                    "id"=> 19,
                    "title" => "Green",
                    "parent_id" => 3,
                    "is_parent" => 0,
                ],
                [
                    "id"=> 20,
                    "title" => "Concentrati",
                    "parent_id" => 3,
                    "is_parent" => 1,
                ],
            [
                "id"=> 4,
                "title" => "ATTREZZI DI PULIZIA",
                "parent_id" => null,
                "is_parent" => 1,
            ],
            [
                "id"=> 5,
                "title" => "CARTA",
                "parent_id" => null,
                "is_parent" => 1,
            ],
            [
                "id"=> 6,
                "title" => "DISPENSER",
                "parent_id" => null,
                "is_parent" => 1,
            ],
            [
                "id"=> 7,
                "title" => "DISPOSITIVI DI PROTEZIONE INDIVIDUALE (DPI)",
                "parent_id" => null,
                "is_parent" => 1,
            ],
            [
                "id"=> 8,
                "title" => "PRIMO SOCCORSO",
                "parent_id" => null,
                "is_parent" => 1,
            ],
            [
                "id"=> 9,
                "title" => "DISINFESTAZIONE",
                "parent_id" => null,
                "is_parent" => 1,
            ],
            [
                "id"=> 10,
                "title" => "LINEA CORTESIA",
                "parent_id" => null,
                "is_parent" => 1,
            ],
        ];

        foreach ($arr as $array){
            $category = category::create($array);
        }

    }
}
