<?php

namespace App\Core\Modules\Administrators\Database\Seeds;

use App\Core\Modules\Administrators\Models\Admin;
use Illuminate\Database\Seeder;
use Faker\Factory AS Fake;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Fake::create();
        
        $user = new Admin();
        $user->first_name = $faker->name;
        $user->email = 'admin@gmail.com';
        $user->password = 'admin';
        $user->remember_token = str_random(10);
        $user->save();
    }
}
