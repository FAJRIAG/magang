<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'name',
        'rfid_uid',
        'reward_balance',
        'last_tap_at',
        'user_id',
    ];

    protected $casts = [
        'last_tap_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function tapLogs()
    {
        return $this->hasMany(TapLog::class);
    }
    public function taskSubmissions()
    {
        return $this->hasMany(TaskSubmission::class);
    }
}
