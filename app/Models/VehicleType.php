<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class VehicleType extends Model
{
     protected $table = 'vehicle_types';
     protected $fillable =['name','status'];


    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function vehicle()
    {
        return $this->hasMany(Vehicle::class, 'vehicle_type', 'id');
    }
     
}
