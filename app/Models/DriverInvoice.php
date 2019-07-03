<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DriverInvoice extends Model
{
    protected $table = 'driver_invoice';
    protected $fillable =['customer_id','total','status'];
    use SoftDeletes;

    public function customer()
    {
        return $this->hasOne('App\Models\Customer','id','customer_id');
    }


}
