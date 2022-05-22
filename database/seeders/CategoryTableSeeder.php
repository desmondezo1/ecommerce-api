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
                            "id"=> 43,
                            "title" => "Johnson Diversey",
                            "parent_id" => 20,
                            "is_parent" => 0,
                        ],
                        [
                            "id"=> 44,
                            "title" => "MD",
                            "parent_id" => 20,
                            "is_parent" => 0,
                        ],
            [
                "id"=> 4,
                "title" => "ATTREZZI DI PULIZIA",
                "parent_id" => null,
                "is_parent" => 1,
            ],
                    [
                        "id"=> 45,
                        "title" => "Panni e Spugne",
                        "parent_id" => 4,
                        "is_parent" => 0,
                    ],
                    [
                        "id"=> 46,
                        "title" => "Scovolo Ragnatele",
                        "parent_id" => 4,
                        "is_parent" => 0,
                    ],[
                        "id"=> 47,
                        "title" => "Scope",
                        "parent_id" => 4,
                        "is_parent" => 1,
                    ],
                            [
                                "id"=> 48,
                                "title" => "Interni ed Esterni",
                                "parent_id" => 47,
                                "is_parent" => 0,
                            ],[
                                "id"=> 49,
                                "title" => "Industriali",
                                "parent_id" => 47,
                                "is_parent" => 0,
                            ],[
                                "id"=> 50,
                                "title" => "Lineari",
                                "parent_id" => 47,
                                "is_parent" => 1,
                            ],
                                    [
                                        "id"=> 51,
                                        "title" => "Frange",
                                        "parent_id" => 50,
                                        "is_parent" => 0,
                                    ],
                                    [
                                        "id"=> 52,
                                        "title" => "Telai",
                                        "parent_id" => 50,
                                        "is_parent" => 0,
                                    ],
                    [
                        "id"=> 53,
                        "title" => "Manici",
                        "parent_id" => 4,
                        "is_parent" => 0,
                    ],[
                        "id"=> 54,
                        "title" => "Palette",
                        "parent_id" => 4,
                        "is_parent" => 0,
                    ],[
                        "id"=> 55,
                        "title" => "Mop",
                        "parent_id" => 4,
                        "is_parent" => 0,
                    ],[
                        "id"=> 56,
                        "title" => "Secchi",
                        "parent_id" => 4,
                        "is_parent" => 0,
                    ],[
                        "id"=> 57,
                        "title" => "Carrelli",
                        "parent_id" => 4,
                        "is_parent" => 1,
                    ],
                            [
                                "id"=> 108,
                                "title" => "Carrelli Completi",
                                "parent_id" => 57,
                                "is_parent" => 0,
                            ],[
                                "id"=> 58,
                                "title" => "Accessori Carrelli",
                                "parent_id" => 57,
                                "is_parent" => 0,
                            ],
                    [
                        "id"=> 59,
                        "title" => "Spingiacqua",
                        "parent_id" => 4,
                        "is_parent" => 0,
                    ],
                    [
                        "id"=> 60,
                        "title" => "Velli Lavavetri",
                        "parent_id" => 4,
                        "is_parent" => 0,
                    ],[
                        "id"=> 61,
                        "title" => "Tergivetro",
                        "parent_id" => 4,
                        "is_parent" => 0,
                    ],[
                        "id"=> 62,
                        "title" => "Raschietti e Lame",
                        "parent_id" => 4,
                        "is_parent" => 0,
                    ],[
                        "id"=> 63,
                        "title" => "Pattumiere",
                        "parent_id" => 4,
                        "is_parent" => 0,
                    ],[
                        "id"=> 64,
                        "title" => "Sacchi N. U.",
                        "parent_id" => 4,
                        "is_parent" => 1,
                    ],
                            [
                                "id"=> 65,
                                "title" => "Piccoli",
                                "parent_id" => 64,
                                "is_parent" => 0,
                            ], [
                                "id"=> 66,
                                "title" => "Medi",
                                "parent_id" => 64,
                                "is_parent" => 0,
                            ],[
                                "id"=> 67,
                                "title" => "Grandi",
                                "parent_id" => 64,
                                "is_parent" => 0,
                            ],
            [
                "id"=> 5,
                "title" => "CARTA",
                "parent_id" => null,
                "is_parent" => 1,
            ],
                    [
                        "id"=> 68,
                        "title" => "Bobine Carta a Rotolo",
                        "parent_id" => 5,
                        "is_parent" => 0,
                    ],[
                        "id"=> 69,
                        "title" => "Asciugamani",
                        "parent_id" => 5,
                        "is_parent" => 1,
                    ],
                            [
                                "id"=> 70,
                                "title" => "Piegati a C-V-Z",
                                "parent_id" => 69,
                                "is_parent" => 0,
                            ], [
                                "id"=> 71,
                                "title" => "A Rotolo",
                                "parent_id" => 69,
                                "is_parent" => 0,
                            ],
                    [
                        "id"=> 72,
                        "title" => "Carta Igienica",
                        "parent_id" => 5,
                        "is_parent" => 1,
                    ],
                                [
                                    "id"=> 73,
                                    "title" => "A Rotolo",
                                    "parent_id" => 72,
                                    "is_parent" => 0,
                                ],[
                                    "id"=> 74,
                                    "title" => "A Foglietti",
                                    "parent_id" => 72,
                                    "is_parent" => 0,
                                ],
                    [
                        "id"=> 75,
                        "title" => "Lenzuolini Medici",
                        "parent_id" => 5,
                        "is_parent" => 0,
                    ],
            [
                "id"=> 6,
                "title" => "DISPENSER",
                "parent_id" => null,
                "is_parent" => 1,
            ],
                        [
                            "id"=> 76,
                            "title" => "Bobine Carta a Rotolo",
                            "parent_id" => 6,
                            "is_parent" => 0,
                        ],[
                            "id"=> 77,
                            "title" => "Asciugamani",
                            "parent_id" => 6,
                            "is_parent" => 0,
                        ],[
                            "id"=> 78,
                            "title" => "Carta Igienica",
                            "parent_id" => 6,
                            "is_parent" => 0,
                        ],[
                            "id"=> 79,
                            "title" => "Sapone",
                            "parent_id" => 6,
                            "is_parent" => 0,
                        ],[
                            "id"=> 80,
                            "title" => "Igienizzanti WC",
                            "parent_id" => 6,
                            "is_parent" => 0,
                        ],[
                            "id"=> 81,
                            "title" => "Profumatori Temporizzati",
                            "parent_id" => 6,
                            "is_parent" => 0,
                        ],
            [
                "id"=> 7,
                "title" => "DISPOSITIVI DI PROTEZIONE INDIVIDUALE (DPI)",
                "parent_id" => null,
                "is_parent" => 1,
            ],
                        [
                            "id"=> 82,
                            "title" => "Guanti",
                            "parent_id" => 7,
                            "is_parent" => 0,
                        ],[
                            "id"=> 83,
                            "title" => "Mascherine",
                            "parent_id" => 7,
                            "is_parent" => 0,
                        ],[
                            "id"=> 84,
                            "title" => "Tute",
                            "parent_id" => 7,
                            "is_parent" => 0,
                        ],[
                            "id"=> 85,
                            "title" => "Cuffie",
                            "parent_id" => 7,
                            "is_parent" => 0,
                        ],[
                            "id"=> 86,
                            "title" => "Copriscarpe",
                            "parent_id" => 7,
                            "is_parent" => 0,
                        ],[
                            "id"=> 87,
                            "title" => "Visiere",
                            "parent_id" => 7,
                            "is_parent" => 0,
                        ],
            [
                "id"=> 8,
                "title" => "PRIMO SOCCORSO",
                "parent_id" => null,
                "is_parent" => 1,
            ],
                        [
                            "id"=> 88,
                            "title" => "Cassette Mediche",
                            "parent_id" => 8,
                            "is_parent" => 0,
                        ], [
                            "id"=> 89,
                            "title" => "Cassette Mediche",
                            "parent_id" => 8,
                            "is_parent" => 0,
                        ],[
                            "id"=> 90,
                            "title" => "Ghiaccio",
                            "parent_id" => 8,
                            "is_parent" => 0,
                        ],[
                            "id"=> 91,
                            "title" => "Cotone",
                            "parent_id" => 8,
                            "is_parent" => 0,
                        ],[
                            "id"=> 92,
                            "title" => "Cerotti",
                            "parent_id" => 8,
                            "is_parent" => 0,
                        ],[
                            "id"=> 93,
                            "title" => "Garze",
                            "parent_id" => 8,
                            "is_parent" => 0,
                        ],[
                            "id"=> 94,
                            "title" => "Lenzuolini Medici",
                            "parent_id" => 8,
                            "is_parent" => 0,
                        ],
            [
                "id"=> 9,
                "title" => "DISINFESTAZIONE",
                "parent_id" => null,
                "is_parent" => 1,
            ],
                        [
                            "id"=> 95,
                            "title" => "DPI",
                            "parent_id" => 9,
                            "is_parent" => 0,
                        ],[
                            "id"=> 96,
                            "title" => "Attrezzature",
                            "parent_id" => 9,
                            "is_parent" => 0,
                        ],[
                            "id"=> 97,
                            "title" => "Monitoraggio",
                            "parent_id" => 9,
                            "is_parent" => 1,
                        ],
                                [
                                    "id"=> 98,
                                    "title" => "Trappole",
                                    "parent_id" => 97,
                                    "is_parent" => 0,
                                ],[
                                    "id"=> 99,
                                    "title" => "Esche",
                                    "parent_id" => 97,
                                    "is_parent" => 0,
                                ],
                        [
                            "id"=> 100,
                            "title" => "Insetticidi",
                            "parent_id" => 9,
                            "is_parent" => 1,
                        ],
                                [
                                    "id"=> 101,
                                    "title" => "Insetticidi in Polvere",
                                    "parent_id" => 100,
                                    "is_parent" => 0,
                                ],[
                                    "id"=> 102,
                                    "title" => "Insetticidi Spray",
                                    "parent_id" => 100,
                                    "is_parent" => 0,
                                ],
            [
                "id"=> 10,
                "title" => "LINEA CORTESIA",
                "parent_id" => null,
                "is_parent" => 1,
            ],
                        [
                            "id"=> 103,
                            "title" => "Prija",
                            "parent_id" => 10,
                            "is_parent" => 0,
                        ],[
                            "id"=> 104,
                            "title" => "Olja",
                            "parent_id" => 10,
                            "is_parent" => 0,
                        ],[
                            "id"=> 105,
                            "title" => "Karisma",
                            "parent_id" => 10,
                            "is_parent" => 0,
                        ],[
                            "id"=> 106,
                            "title" => "Neutra",
                            "parent_id" => 10,
                            "is_parent" => 0,
                        ],[
                            "id"=> 107,
                            "title" => "Accessori",
                            "parent_id" => 10,
                            "is_parent" => 0,
                        ],
        ];

        foreach ($arr as $array){
            $category = category::create($array);
        }

    }
}
