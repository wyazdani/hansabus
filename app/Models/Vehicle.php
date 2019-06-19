<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Vehicle extends Model
{
     protected $table = 'vehicle';
     


     public function type()
    {
        return $this->hasOne('App\Models\VehicleType', 'id', 'vehicle_type');
    }

}
