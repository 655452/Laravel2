<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Balance;
use Illuminate\Support\Facades\DB;

class CategoryMenuItemsSeeder extends Seeder
{
    public array $categoryMenuItemsOptions = [
        [
            "category_id"  => "23",
            "menu_item_id" => '1',
        ],
        [
            "category_id"  => "23",
            "menu_item_id" => '2',
        ],
        [
            "category_id"  => "24",
            "menu_item_id" => '3',
        ],
        [
            "category_id"  => "24",
            "menu_item_id" => '4',
        ],
        [
            "category_id"  => "24",
            "menu_item_id" => '6',
        ],
        [
            "category_id"  => "8",
            "menu_item_id" => '7',
        ],
        [
            "category_id"  => "1",
            "menu_item_id" => '8',
        ],
        [
            "category_id"  => "1",
            "menu_item_id" => '9',
        ],
        [
            "category_id"  => "8",
            "menu_item_id" => '10',
        ],
        [
            "category_id"  => "2",
            "menu_item_id" => '11',
        ],
        [
            "category_id"  => "2",
            "menu_item_id" => '11',
        ],
        [
            "category_id"  => "8",
            "menu_item_id" => '13',
        ],
        [
            "category_id"  => "8",
            "menu_item_id" => '14',
        ],
        [
            "category_id"  => "24",
            "menu_item_id" => '15',
        ],
        [
            "category_id"  => "8",
            "menu_item_id" => '16',
        ],
        [
            "category_id"  => "11",
            "menu_item_id" => '17',
        ],
        [
            "category_id"  => "8",
            "menu_item_id" => '18',
        ],
        [
            "category_id"  => "20",
            "menu_item_id" => '19',
        ],
        [
            "category_id"  => "17",
            "menu_item_id" => '21',
        ],
        [
            "category_id"  => "1",
            "menu_item_id" => '22',
        ],
        [
            "category_id"  => "36",
            "menu_item_id" => '23',
        ],
        [
            "category_id"  => "36",
            "menu_item_id" => '24',
        ],
        [
            "category_id"  => "20",
            "menu_item_id" => '25',
        ],
        [
            "category_id"  => "35",
            "menu_item_id" => '30',
        ],
        [
            "category_id"  => "11",
            "menu_item_id" => '31',
        ],
        [
            "category_id"  => "34",
            "menu_item_id" => '32',
        ],
        [
            "category_id"  => "33",
            "menu_item_id" => '29',
        ],
        [
            "category_id"  => "20",
            "menu_item_id" => '34',
        ],
        [
            "category_id"  => "45",
            "menu_item_id" => '33',
        ],
        [
            "category_id"  => "32",
            "menu_item_id" => '35',
        ],
        [
            "category_id"  => "32",
            "menu_item_id" => '37',
        ],
        [
            "category_id"  => "46",
            "menu_item_id" => '38',
        ],
        [
            "category_id"  => "46",
            "menu_item_id" => '39',
        ],
        [
            "category_id"  => "11",
            "menu_item_id" => '40',
        ],
        [
            "category_id"  => "11",
            "menu_item_id" => '41',
        ],
        [
            "category_id"  => "35",
            "menu_item_id" => '42',
        ],
        [
            "category_id"  => "47",
            "menu_item_id" => '43',
        ],
        [
            "category_id"  => "20",
            "menu_item_id" => '44',
        ],
        [
            "category_id"  => "34",
            "menu_item_id" => '26',
        ],
        [
            "category_id"  => "47",
            "menu_item_id" => '45',
        ],
        [
            "category_id"  => "11",
            "menu_item_id" => '46',
        ],
        [
            "category_id"  => "33",
            "menu_item_id" => '27',
        ],
        [
            "category_id"  => "11",
            "menu_item_id" => '47',
        ],
        [
            "category_id"  => "48",
            "menu_item_id" => '48',
        ],
        [
            "category_id"  => "48",
            "menu_item_id" => '49',
        ],
        [
            "category_id"  => "8",
            "menu_item_id" => '50',
        ],
        [
            "category_id"  => "48",
            "menu_item_id" => '51',
        ],
        [
            "category_id"  => "8",
            "menu_item_id" => '52',
        ],
        [
            "category_id"  => "49",
            "menu_item_id" => '53',
        ],
        [
            "category_id"  => "49",
            "menu_item_id" => '54',
        ],
        [
            "category_id"  => "48",
            "menu_item_id" => '57',
        ],
        [
            "category_id"  => "12",
            "menu_item_id" => '58',
        ],
        [
            "category_id"  => "12",
            "menu_item_id" => '59',
        ],
        [
            "category_id"  => "6",
            "menu_item_id" => '60',
        ],
        [
            "category_id"  => "20",
            "menu_item_id" => '61',
        ],

        [
            "category_id"  => "13",
            "menu_item_id" => '62',
        ],

        [
            "category_id"  => "13",
            "menu_item_id" => '63',
        ],

        [
            "category_id"  => "6",
            "menu_item_id" => '64',
        ],
        [
            "category_id"  => "20",
            "menu_item_id" => '65',
        ],

        [
            "category_id"  => "23",
            "menu_item_id" => '67',
        ],

        [
            "category_id"  => "12",
            "menu_item_id" => '68',
        ],
        [
            "category_id"  => "50",
            "menu_item_id" => '69',
        ],
        [
            "category_id"  => "23",
            "menu_item_id" => '70',
        ],
        [
            "category_id"  => "50",
            "menu_item_id" => '71',
        ],
        [
            "category_id"  => "12",
            "menu_item_id" => '72',
        ],
        [
            "category_id"  => "30",
            "menu_item_id" => '73',
        ],
        [
            "category_id"  => "30",
            "menu_item_id" => '74',
        ],  [
            "category_id"  => "12",
            "menu_item_id" => '75',
        ],
        [
            "category_id"  => "1",
            "menu_item_id" => '77',
        ],
        [
            "category_id"  => "1",
            "menu_item_id" => '78',
        ],
        [
            "category_id"  => "12",
            "menu_item_id" => '76',
        ],
        [
            "category_id"  => "12",
            "menu_item_id" => '66',
        ],
        [
            "category_id"  => "20",
            "menu_item_id" => '79',
        ],
        [
            "category_id"  => "20",
            "menu_item_id" => '80',
        ],
        [
            "category_id"  => "6",
            "menu_item_id" => '36',
        ],
        [
            "category_id"  => "6",
            "menu_item_id" => '20',
        ],
        [
            "category_id"  => "12",
            "menu_item_id" => '81',
        ],

    ];

    /**
     * Run the database seeds.
     */

     public function run()
     {
         if (env('DEMO_MODE')) {
             foreach ($this->categoryMenuItemsOptions as $categoryMenuItemsOption) {
                 DB::table('category_menu_items')->insert([
                     'category_id'  => $categoryMenuItemsOption['category_id'],
                     'menu_item_id' => $categoryMenuItemsOption['menu_item_id'],
                 ]);
             }
         }
     }
}
