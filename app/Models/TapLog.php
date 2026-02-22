<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TapLog extends Model
{
    protected $fillable = [
        'employee_id',
        'rfid_uid',
        'status',
        'reason',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
