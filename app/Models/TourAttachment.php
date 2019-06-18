<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TourAttachment extends Model
{
    protected $table = 'tour_attachments';
    protected $fillable =['tour_id','file','ext'];
}