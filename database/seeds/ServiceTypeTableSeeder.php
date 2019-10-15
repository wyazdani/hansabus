<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('bus_service_type')->insert(
            [['name' => 'Bus Wash'],['name' => 'Other Services']]
        );
    }
}
