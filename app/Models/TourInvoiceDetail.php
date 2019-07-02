<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TourInvoiceDetail extends Model
{
    protected $table = 'tour_invoice_details';
    protected $fillable =['invoice_id','tour_id'];
    use SoftDeletes;

    public function tour()
    {
        return $this->hasOne('App\Models\Tour','id','tour_id');
    }
}
