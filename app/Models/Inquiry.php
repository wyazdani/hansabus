<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    protected $fillable =   ['name','email','is_web','with_driver','status','seats','description','is_deleted'];


    public function inquiryaddresses()
    {
        return  $this->hasMany(InquiryAddress::class,'inquiry_id','id');
    }
    public function offer(){
        return $this->hasOne(Offer::class,'inquiry_id','id');
    }
}
