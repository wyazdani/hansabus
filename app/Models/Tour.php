<?php

namespace App\Models;

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
        'price',
        'description'
    ];

    protected $dates = ['deleted_at'];
    use SoftDeletes;

    public function attachments()
    {
        return $this->hasMany('App\Models\TourAttachment','tour_id','id')->select(['id','file']);
    }
    public function customer()
    {
        return $this->hasOne('App\Models\Customer','id','customer_id')->select(['id','name']);
    }

    public function vehicle()
    {
        return $this->hasOne('App\Models\Vehicle','id','vehicle_id');
    }

    public function driver()
    {
        return $this->hasOne('App\Models\Driver','id','driver_id')->select(['id','driver_name']);
    }

    public function tourdetails()
    {
        return  $this->hasOne(TourInvoiceDetail::class,'invoice_id','id');
    }
}
