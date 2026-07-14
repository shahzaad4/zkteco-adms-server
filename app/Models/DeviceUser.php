<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeviceUser extends Model
{
    protected $fillable = [
        'sn',
        'user_id',
        'name',
        'privilege',
        'password',
        'card',
        'group_id',
        'raw_data',
    ];
}
