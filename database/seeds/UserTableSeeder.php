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
        'email'      =>  'admin@ecoach.com',
        'password'   =>  bcrypt('123456')
    ]);
    }
}
