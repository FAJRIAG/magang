<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Attendance;
use App\Models\TapLog;
use App\Models\Configuration;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class TapController extends Controller
{
    public function tap(Request $request)
    {
        $request->validate([
            'rfid_uid' => 'required|string',
            'device_id' => 'required|string|exists:devices,device_id',
            'signature' => 'required|string',
        ]);

        $rfid = $request->input('rfid_uid');

        $employee = Employee::where('rfid_uid', $rfid)->first();

        if (!$employee) {
            TapLog::create([
                'rfid_uid' => $rfid,
                'status' => 'DENY',
                'reason' => 'Unknown RFID',
            ]);
            return response()->json(['status' => 'DENY', 'reason' => 'Unknown tag'], 200);
        }

        // Fetch Configuration
        $cooldownSeconds = (int) (Configuration::where('key', 'cooldown_seconds')->value('value') ?? 10);
        $dailyLimit = (int) (Configuration::where('key', 'daily_limit')->value('value') ?? 2);

        // Cooldown check
        if ($employee->last_tap_at && $employee->last_tap_at->diffInSeconds(Carbon::now()) < $cooldownSeconds) {
            TapLog::create([
                'employee_id' => $employee->id,
                'rfid_uid' => $rfid,
                'status' => 'DENY',
                'reason' => 'Cooldown active',
            ]);
            return response()->json(['status' => 'DENY', 'reason' => "Cooldown ({$cooldownSeconds}s)"], 200);
        }

        $today = Carbon::today();

        // Daily limit check
        $dailyTaps = TapLog::where('employee_id', $employee->id)
            ->whereDate('created_at', $today)
            ->where('status', 'ALLOW')
            ->count();

        if ($dailyTaps >= $dailyLimit) {
            TapLog::create([
                'employee_id' => $employee->id,
                'rfid_uid' => $rfid,
                'status' => 'DENY',
                'reason' => 'Daily limit reached',
            ]);
            return response()->json(['status' => 'DENY', 'reason' => 'Daily limit reached'], 200);
        }

        // Attendance State Machine
        $attendance = Attendance::where('employee_id', $employee->id)
            ->where('date', $today)
            ->first();

        $pulseDuration = (int) (Configuration::where('key', 'pulse_duration')->value('value') ?? 3000);

        if (!$attendance) {
            // CHECK-IN
            Attendance::create([
                'employee_id' => $employee->id,
                'date' => $today,
                'check_in' => Carbon::now(),
            ]);

            $this->grantReward($employee, $rfid, 'CHECKIN');

            return response()->json([
                'status' => 'ALLOW',
                'type' => 'CHECKIN',
                'dispense' => true,
                'duration' => $pulseDuration
            ]);

        } elseif ($attendance->check_out === null) {
            // CHECK-OUT
            $attendance->update([
                'check_out' => Carbon::now(),
            ]);

            $this->grantReward($employee, $rfid, 'CHECKOUT');

            return response()->json([
                'status' => 'ALLOW',
                'type' => 'CHECKOUT',
                'dispense' => true,
                'duration' => $pulseDuration
            ]);

        } else {
            // COMPLETED
            TapLog::create([
                'employee_id' => $employee->id,
                'rfid_uid' => $rfid,
                'status' => 'DENY',
                'reason' => 'Already completed',
            ]);
            return response()->json(['status' => 'DENY', 'reason' => 'Already completed'], 200);
        }
    }

    private function grantReward($employee, $rfid, $type)
    {
        $employee->increment('reward_balance');
        $employee->update(['last_tap_at' => Carbon::now()]);

        TapLog::create([
            'employee_id' => $employee->id,
            'rfid_uid' => $rfid,
            'status' => 'ALLOW',
            'reason' => $type,
        ]);
    }
}
