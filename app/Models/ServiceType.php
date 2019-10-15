<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceType extends Model
{
    protected $table = 'bus_service_type';
    protected $fillable =[
        'name'
    ];

    use SoftDeletes;
    protected $dates = ['deleted_at'];

}
