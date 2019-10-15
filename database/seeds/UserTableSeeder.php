<?php

use App\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::updateOrCreate([
        'name'       =>  'Admin',
        'email'      =>  'info@hansabus.com',
        'password'   =>  bcrypt('12345678')
    ]);
    }
}
