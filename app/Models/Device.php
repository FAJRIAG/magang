<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $fillable = [
        'device_id',
        'secret_key',
        'location',
    ];

    protected $hidden = [
        'secret_key',
    ];
}
