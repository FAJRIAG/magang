<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RewardExchange extends Model
{
    protected $fillable = [
        'employee_id',
        'reward_product_id',
        'points_spent',
        'status',
        'reason',
    ];

    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }

    public function rewardProduct()
    {
        return $this->belongsTo(RewardProduct::class);
    }
}
