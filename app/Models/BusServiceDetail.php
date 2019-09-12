<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BusServiceDetail extends Model
{
    use SoftDeletes;
    protected $table = 'bus_service_detail';
    protected $fillable = ['title','price'];


}
