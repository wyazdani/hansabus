<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TourStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('tour_status')->insert(
            [['name' => 'Draft'],['name' => 'Confirmed'],['name' => 'Invoiced'],['name' => 'Paid'],['name' => 'Canceled']]
        );
    }
}
