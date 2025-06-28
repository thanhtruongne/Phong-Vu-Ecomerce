<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Permissions;
use App\Models\Profile;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;

class UserDatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \DB::table('user')->truncate();
        /***** superadmin *******/
        $superadmin = User::firstOrNew(['username' => 'superadmin'], [
            'username' => 'superadmin',
            'password' => \Hash::make('123123'),
            'firstname' => 'Super',
            'lastname' => 'Admin',
            'email' => 'superadmin@gmail.com',
            'status' => 1,
            'dob' => date('Y-m-d 00:00:00'),
            'gender' => 1,
        ]);
        $superadmin->save();
    }
}
