<?php

namespace App;

use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class tours extends Model
{
    protected $fillable = [
        'tour_id',
        'driver_id',
        'customer_id',
        'tour_name',
        'price',
        'location',
        'destination',
        'departure_date',

    ];

    protected $dates = ['deleted_at'];
    use SoftDeletes;

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class,'vehicle_id','id');
    }
}
