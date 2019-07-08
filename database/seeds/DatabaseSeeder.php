<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $this->call(TourStatusTableSeeder::class);
         $this->call(VehicleTypeTableSeeder::class);
         $this->call(UserTableSeeder::class);
    }
}
