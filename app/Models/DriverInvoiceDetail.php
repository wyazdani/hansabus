<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DriverInvoiceDetail extends Model
{
    protected $table = 'driver_invoice_detail';
    protected $fillable =['invoice_id','hire_id'];
    use SoftDeletes;

    public function hire()
    {
        return $this->hasOne('App\Models\HireDriver','id','hire_id');
    }
}
