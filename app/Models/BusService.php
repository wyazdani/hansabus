<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BusService extends Model
{
    use SoftDeletes;
    protected $table = 'bus_service';
    protected $fillable = ['type_id','customer','total','vat'];

    public function details(){

        return $this->hasMany('App\Models\BusServiceDetail','service_id','id');
    }

    public function service()
    {
//        return $this->hasOne('App\Models\ServiceType','service_type','id')->get();
        return $this->hasOne('App\Models\ServiceType', 'id', 'type_id');
    }
}
