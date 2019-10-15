<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HireDriver extends Model
{
    protected $table = 'hire_a_driver';
    protected $fillable =[

        'status',
        'customer_id',
        'driver_id',
        'from_date',
        'to_date',
        'price',
        'color'
    ];

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function attachments()
    {
        return $this->hasMany('App\Models\HireAttachment','hire_id','id')->select(['id','file']);
    }
    public function customer()
    {
        return $this->hasOne('App\Models\Customer','id','customer_id')->select(['id','name']);
    }

    public function driver()
    {
        return $this->hasOne('App\Models\Driver','id','driver_id')->select(['id','driver_name','driver_license']);
    }
}
