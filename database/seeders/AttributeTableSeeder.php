<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Categories;
use App\Models\Permissions;
use App\Models\Profile;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Modules\Products\Entities\Attribute;

class AttributeTableSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // // \DB::table('user')->truncate();
        $attributeParent = [
            //kích thước màn hình
           [
            'name' => '13.4"',
            'parent_id' => 1,
            'status' => 1
           ],
           [
            'name' => '14"',
            'parent_id' => 1,
            'status' => 1
           ],
           [
            'name' => '15.6"',
            'parent_id' => 1,
            'status' => 1
           ],
           [
            'name' => '16"',
            'parent_id' => 1,
            'status' => 1
           ],


        //Màu sắc
           [
            'name' => 'Gold',
            'parent_id' => 2,
            'status' => 1
           ],
           [
            'name' => 'Midnight',
            'parent_id' => 2,
            'status' => 1
           ],
           [
            'name' => 'Silver',
            'parent_id' => 2,
            'status' => 1
           ],
           [
            'name' => 'Space Grey',
            'parent_id' => 2,
            'status' => 1
           ],
           [
            'name' => 'StarLight',
            'parent_id' => 2,
            'status' => 1
           ],

           //Màu sắc
           [
            'name' => '8GB',
            'parent_id' => 3,
            'status' => 1
           ],
           [
            'name' => '16GB',
            'parent_id' => 3,
            'status' => 1
           ],
           [
            'name' => '24GB',
            'parent_id' => 3,
            'status' => 1
           ],

           //Series CPU
           [
            'name' => 'Core 5',
            'parent_id' => 4,
            'status' => 1
           ],
           [
            'name' => 'Core 7',
            'parent_id' => 4,
            'status' => 1
           ],
           [
            'name' => 'Core Ultra 5',
            'parent_id' => 4,
            'status' => 1
           ],
           [
            'name' => 'Core Ultra 7',
            'parent_id' => 4,
            'status' => 1
           ],
           [
            'name' => 'Core i3',
            'parent_id' => 4,
            'status' => 1
           ],
           [
            'name' => 'Core i5',
            'parent_id' => 4,
            'status' => 1
           ],
           [
            'name' => 'Core i7',
            'parent_id' => 4,
            'status' => 1
           ],

            //Thiết kế CPU
            [
                'name' => 'AMD',
                'parent_id' => 5,
                'status' => 1
            ],
            [
                'name' => 'Intel AI',
                'parent_id' => 5,
                'status' => 1
            ],
            [
                'name' => 'Non EVO',
                'parent_id' => 5,
                'status' => 1
            ],

              //Chip đồ họa rời
              [
                'name' => 'Onboard',
                'parent_id' => 6,
                'status' => 1
            ],
            [
                'name' => 'GeForce MX550',
                'parent_id' => 6,
                'status' => 1
            ],
            [
                'name' => 'GeForce MX570A',
                'parent_id' => 6,
                'status' => 1
            ],
            [
                'name' => 'Geforce RTX 2000',
                'parent_id' => 6,
                'status' => 1
            ],
            [
                'name' => 'Geforce RTX 2050',
                'parent_id' => 6,
                'status' => 1
            ],
            [
                'name' => 'Geforce RTX 4050',
                'parent_id' => 6,
                'status' => 1
            ],
            [
                'name' => 'RTX A1000',
                'parent_id' => 6,
                'status' => 1
            ],

              //Chuẩn đồ họa rời
              [
                'name' => '2.2 ',
                'parent_id' => 7,
                'status' => 1
            ],
            [
                'name' => 'Full HD',
                'parent_id' => 7,
                'status' => 1
            ],
            [
                'name' => 'Full HD+',
                'parent_id' => 7,
                'status' => 1
            ],
            [
                'name' => 'Khác',
                'parent_id' => 7,
                'status' => 1
            ],
            [
                'name' => 'HD',
                'parent_id' => 7,
                'status' => 1
            ],
            [
                'name' => 'WUXGA',
                'parent_id' => 7,
                'status' => 1
            ],
        
        ];
        // //  \DB::table('user')->inde();
        foreach($attributeParent as $item){
            Attribute::create($item);
        }
    }
}
