<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TourStatus extends Model
{
    protected $table = 'tour_status';
    protected $fillable =['name'];


    use SoftDeletes;
    protected $dates = ['deleted_at'];

}