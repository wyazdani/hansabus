<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
   protected $fillable  =   ['inquiry_id','price','comment'];
   public function offer_tour(){
       return $this->hasOne(OfferTour::class,'offer_id','id');
   }
}
