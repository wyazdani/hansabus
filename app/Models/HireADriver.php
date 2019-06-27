<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HireADriver extends Model
{
    protected $table = 'hire_a_driver';
    protected $fillable =[

        'status',
        'customer_id',
        'driver_id',
        'from_date',
        'to_date',
        'price'
    ];

    use SoftDeletes;
    protected $dates = ['deleted_at'];
}
