<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TourInvoice extends Model
{
    protected $table = 'tour_invoice';
    protected $fillable =['customer_id','total','status','is_bulk','subject','body'];
    use SoftDeletes;

    public function customer()
    {
        return $this->hasOne('App\Models\Customer','id','customer_id');
    }


}
