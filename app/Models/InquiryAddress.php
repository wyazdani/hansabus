<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InquiryAddress extends Model
{
    protected $fillable =   ['inquiry_id','from_address','to_address','time','trip_type','status'];
}
