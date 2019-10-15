<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Vehicle extends Model
{
    use SoftDeletes;
     protected $table = 'vehicle';
    protected $dates = ['deleted_at'];
     


     public function type()
    {
        return $this->hasOne('App\Models\VehicleType', 'id', 'vehicle_type');
    }

}
