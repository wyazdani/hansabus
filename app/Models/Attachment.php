<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attachment extends Model
{
    protected $table = 'attachments';
    protected $fillable = [
        'file','ext','temp_key'
    ];
}
