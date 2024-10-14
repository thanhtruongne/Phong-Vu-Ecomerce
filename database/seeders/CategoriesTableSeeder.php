<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Categories;
use App\Models\Permissions;
use App\Models\Profile;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \DB::table('user')->truncate();
        $categoriesParent = [

            //Nhu cầu
            [
                'name' => 'Acer',
                'parent_id' => 4,
                'status' => 1
            ],
            [
                'name' => 'Asus',
                'parent_id' => 4,
                'status' => 1
            ],
            [
                'name' => 'Dell',
                'parent_id' => 4,
                'status' => 1
            ],
            [
                'name' => 'HP',
                'parent_id' => 4,
                'status' => 1
            ],
            [
                'name' => 'LENOVO',
                'parent_id' => 4,
                'status' => 1
            ],
            [
                'name' => 'MSI  ',
                'parent_id' => 4,
                'status' => 1
            ],
            [
                'name' => 'Apple',
                'parent_id' => 4,
                'status' => 1
            ],
            [
                'name' => 'Gigabyte',
                'parent_id' => 4,
                'status' => 1
            ],

            //Kích thước


            [
                'name' => 'Dưới 13 inch',
                'parent_id' => 5,
                'status' => 1
            ],
            [
                'name' => '13 -15 inch',
                'parent_id' => 5,
                'status' => 1
            ],
            [
                'name' => 'Trên 15 inch',
                'parent_id' => 5,
                'status' => 1
            ],
            [
                'name' => 'Laptop 13 inch',
                'parent_id' => 5,
                'status' => 1
            ],
            [
                'name' => 'Laptop 14 inch',
                'parent_id' => 5,
                'status' => 1
            ],
            [
                'name' => 'Laptop 15 inch',
                'parent_id' => 5,
                'status' => 1
            ],
            [
                'name' => 'Laptop 16 inch',
                'parent_id' => 5,
                'status' => 1
            ],
            [
                'name' => 'Laptop 17 inch',
                'parent_id' => 5,
                'status' => 1
            ],

            //Cấu hình
            [
                'name' => 'Laptop i5',
                'parent_id' => 6,
                'status' => 1
            ],
            [
                'name' => 'Laptop i7',
                'parent_id' => 6,
                'status' => 1
            ],
            [
                'name' => 'Laptop i9',
                'parent_id' => 6,
                'status' => 1
            ],
            [
                'name' => 'Laptop Ryzen 5',
                'parent_id' => 6,
                'status' => 1
            ],
            [
                'name' => 'Laptop Ryzen 7',
                'parent_id' => 6,
                'status' => 1
            ],
            [
                'name' => 'Laptop Ultra 5',
                'parent_id' => 6,
                'status' => 1
            ],
                 [
                'name' => 'Laptop Ultra 6',
                'parent_id' => 6,
                'status' => 1
            ],
            [
                'name' => 'Laptop Ultra 7',
                'parent_id' => 6,
                'status' => 1
            ],

            //Mức giá
            [
                'name' => 'Dưới 10 triệu',
                'parent_id' => 7,
                'status' => 1
            ],
            [
                'name' => '10 - 15 triệu',
                'parent_id' => 7,
                'status' => 1
            ],
            [
                'name' => '15 - 20 triệu',
                'parent_id' => 7,
                'status' => 1
            ],
            [
                'name' => '20 - 25 triệu',
                'parent_id' => 7,
                'status' => 1
            ],
            [
                'name' => '25 - 30 triệu',
                'parent_id' => 7,
                'status' => 1
            ],
            [
                'name' => 'Trên 30 triệu',
                'parent_id' => 7,
                'status' => 1
            ],
        ];
        //  \DB::table('user')->inde();
        foreach($categoriesParent as $item){
            Categories::create($item);
        }
    }
}
