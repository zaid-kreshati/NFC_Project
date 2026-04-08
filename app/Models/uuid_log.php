<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UuidLog extends Model
{
    protected $table = 'uuid_logs';
    protected $fillable = ['uuid', 'status', 'device_id', 'message'];
}
