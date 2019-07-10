<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VehicleTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('vehicle_types')->insert(
            [['name' => 'Car','status'=>1],['name' => 'Bus','status'=>1]]
        );
    }
}
