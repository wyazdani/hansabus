<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Driver extends Model
{
    protected $fillable =[
        'driver_name',
        'mobile_number',
        'driver_license',
        'nic',
        'address',
        'phone',
        'other_details',
    ];

    use SoftDeletes;
    protected $dates = ['deleted_at'];



}
