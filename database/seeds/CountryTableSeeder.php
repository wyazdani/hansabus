<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $countries_data =   file_get_contents(__DIR__."/countries.json");
        $countries      =   json_decode($countries_data);
        foreach ($countries as $key =>   $country){
            $db_country   =   \App\Models\Country::where('country_name','=',$country->name)->first();
            if ($db_country){
                $db_country->update([
                    'country_name'      =>  $country->name,
                    'country_code'      =>  $key,
                    'dialup_code'       =>  $country->phone,
                    'currency'          =>  $country->currency
                ]);
            }
            else{
                \App\Models\Country::create([
                    'country_name'      =>  $country->name,
                    'country_code'      =>  $key,
                    'dialup_code'       =>  $country->phone,
                    'currency'          =>  $country->currency
                ]);
            }
        }
    }
}
