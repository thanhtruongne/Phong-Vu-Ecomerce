<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Categories;
use App\Models\Permissions;
use App\Models\Profile;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Modules\Products\Entities\ProductCateloge;

class ProductCatelogeTableSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \DB::table('user')->truncate();
        // $categoriesParent = [

        //     //Nhu cầu
        //     [
        //         'name' => 'Acer Aspire',
        //         'parent_id' => 10,
        //         'status' => 1
        //     ],
        //     [
        //         'name' => 'Acer Predator Gaming',
        //         'parent_id' => 10,
        //         'status' => 1
        //     ],
        //     [
        //         'name' => 'Acer Swift',
        //         'parent_id' => 10,
        //         'status' => 1
        //     ],
        //     [
        //         'name' => 'Acer Nitro Gaming',
        //         'parent_id' => 10,
        //         'status' => 1
        //     ],
        //     [
        //         'name' => 'Acer Swift Go AI',
        //         'parent_id' => 10,
        //         'status' => 1
        //     ],
        //     [
        //         'name' => 'Predator Helios Neo 11  ',
        //         'parent_id' => 10,
        //         'status' => 1
        //     ],
        //     [
        //         'name' => 'Nitro V16',
        //         'parent_id' => 10,
        //         'status' => 1
        //     ],
        //     [
        //         'name' => 'Nitro V15',
        //         'parent_id' => 10,
        //         'status' => 1
        //     ],
            
        //     //Asus
        //     [
        //         'name' => 'ASUS TUF GAMING',
        //         'parent_id' => 11,
        //         'status' => 1
        //     ],
        //     [
        //         'name' => 'ASUS ROG GAMING',
        //         'parent_id' => 11,
        //         'status' => 1
        //     ],
        //     [
        //         'name' => 'ASUS Vivobook',
        //         'parent_id' => 11,
        //         'status' => 1
        //     ],
        //     [
        //         'name' => 'ASUS Zenbook',
        //         'parent_id' => 11,
        //         'status' => 1
        //     ],

        //      //Apple
        //      [
        //         'name' => 'Macbook Air',
        //         'parent_id' => 12,
        //         'status' => 1
        //     ],
        //     [
        //         'name' => 'Macbook Pro',
        //         'parent_id' => 12,
        //         'status' => 1
        //     ],
        //     //HP
        //     [
        //         'name' => 'HP Pavillon',
        //         'parent_id' => 13,
        //         'status' => 1
        //     ],
        //     [
        //         'name' => 'HP Probook',
        //         'parent_id' => 13,
        //         'status' => 1
        //     ],
        //     [
        //         'name' => 'HP Omens',
        //         'parent_id' => 13,
        //         'status' => 1
        //     ],
        //     [
        //         'name' => 'HP Victus',
        //         'parent_id' => 13,
        //         'status' => 1
        //     ],
        //       //MSI
        //       [
        //         'name' => 'MSI GF series',
        //         'parent_id' => 14,
        //         'status' => 1
        //     ],
        //     [
        //         'name' => 'MSI Modren',
        //         'parent_id' => 14,
        //         'status' => 1
        //     ],
        //     [
        //         'name' => 'MSI Cyborg',
        //         'parent_id' => 14,
        //         'status' => 1
        //     ],
        //     [
        //         'name' => 'MSI Katana',
        //         'parent_id' => 14,
        //         'status' => 1
        //     ],
        //        //MSI
        //        [
        //         'name' => 'Dell Inspiron',
        //         'parent_id' => 15,
        //         'status' => 1
        //     ],
        //     [
        //         'name' => 'Dell Vostro',
        //         'parent_id' => 15,
        //         'status' => 1
        //     ],
        //     [
        //         'name' => 'Dell XPS',
        //         'parent_id' => 15,
        //         'status' => 1
        //     ],
        //     [
        //         'name' => 'Dell Latitude',
        //         'parent_id' => 15,
        //         'status' => 1
        //     ],
        //     // [
        //     //     'name' => 'ASUS Vivobook',
        //     //     'parent_id' => 11,
        //     //     'status' => 1
        //     // ],
        //     // [
        //     //     'name' => 'ASUS Zenbook',
        //     //     'parent_id' => 11,
        //     //     'status' => 1
        //     // ],



          
        // ];
        $categoriesParent = [
            [
                'name' => 'Macbook Air M1',
                'parent_id' => 28,
                'status' => 1                   
            ],
            [
                'name' => 'Macbook Air M2 13 inch',
                'parent_id' => 28,
                'status' => 1                   
            ],
            [
                'name' => 'Macbook Air M2 15 inch',
                'parent_id' => 28,
                'status' => 1                   
            ],
            [
                'name' => 'Macbook Air M3 13 inch',
                'parent_id' => 28,
                'status' => 1                   
            ],


            [
                'name' => 'Macbook Pro 14 inch M3',
                'parent_id' => 29,
                'status' => 1                   
            ],
            [
                'name' => 'Macbook Pro 14 inch M3 Pro',
                'parent_id' => 29,
                'status' => 1                   
            ],
            [
                'name' => 'Macbook Pro 16 inch M3 Pro',
                'parent_id' => 29,
                'status' => 1                   
            ],
            [
                'name' => 'Macbook Pro 14 inch M3 Max',
                'parent_id' => 29,
                'status' => 1                   
            ],
        ];
        //  \DB::table('user')->inde();
        foreach($categoriesParent as $item){
            ProductCateloge::create($item);
        }
    }
}
