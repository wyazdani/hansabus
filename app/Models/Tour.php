<?php

namespace App\Models;

use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tour extends Model
{
    protected $table = 'tours';
    protected $fillable = [

        'status',
        'customer_id',
        'vehicle_id',

        'from_date',
        'to_date',
        'driver_id',

        'passengers',
        'guide',
        'price'
    ];

    protected $dates = ['deleted_at'];
    use SoftDeletes;

//    public function vehicles()
//    {
//        return $this->hasMany(Vehicle::class,'vehicle_id','id');
//    }
}
