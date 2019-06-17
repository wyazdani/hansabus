<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use SoftDeletes;
    protected $table = 'customer';
    protected $fillable = ['name','email','url','address','phone','status'];
    protected $dates = ['deleted_at'];


    /* customer tours */
//    public function tours(){
//
//        return $this->hasMany('App\Models\tours', 'id', 'customer_id');
//    }

}
