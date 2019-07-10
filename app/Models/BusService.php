<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BusService extends Model
{
    use SoftDeletes;
    protected $table = 'bus_service';
    protected $fillable = ['customer','total'];

    public function servicesTitle(){

        return $this->hasMany('App\Models\BusServiceDetail','service_id','id')->get();
    }

    public function services()
    {
        return $this->hasMany('App\Models\BusServiceDetail','service_id','id')->get();
    }

}
