<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DriverBooking extends Model
{
    protected $table = 'driver_bookings';
    protected $fillable = [

        'from_date',
        'to_date',
        'driver_id',
        'with_vehicle',
        'booking_id'
    ];
}
