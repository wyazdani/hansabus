<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class HireAttachment extends Model
{
    protected $table = 'hire_a_driver_attachments';
    protected $fillable =['hire_id','file','ext'];
}
