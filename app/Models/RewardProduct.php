<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RewardProduct extends Model
{
    protected $fillable = [
        'name',
        'type',
        'points_cost',
        'image_path',
        'stock',
        'is_active',
    ];
}
