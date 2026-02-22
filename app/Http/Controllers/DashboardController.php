<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Attendance;
use App\Models\TapLog;
use App\Models\TaskSubmission;
use Carbon\Carbon;

use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role !== 'employee') {
            // Admin Dashboard
            $totalEmployees = Employee::count();
            $presentToday = Attendance::query()->whereDate('date', Carbon::today()->toDateString())->count();
            $totalRewards = Employee::sum('reward_balance');
            $recentLogs = TapLog::with('employee')->latest()->take(10)->get();

            return view('dashboard', compact('totalEmployees', 'presentToday', 'totalRewards', 'recentLogs'));
        }

        // Employee Dashboard
        $employee = $user->employee;
        $recentLogs = $employee ? $employee->tapLogs()->latest()->take(20)->get() : collect();
        $myTasks = $employee ? TaskSubmission::where('employee_id', $employee->id)
            ->whereIn('status', ['assigned', 'pending_approval'])
            ->with('task')
            ->get() : collect();

        return view('dashboard-employee', compact('employee', 'recentLogs', 'myTasks'));
    }

    public function employees()
    {
        if (auth()->check() && auth()->user()->role === 'employee')
            abort(403);
        $employees = Employee::with('user')->latest()->get();

        return view('employees', compact('employees'));
    }

    public function storeEmployee(Request $request)
    {
        if (auth()->check() && auth()->user()->role === 'employee')
            abort(403);
        $request->validate([
            'name' => 'required|string',
        ]);

        Employee::create([
            'name' => $request->name,
            'rfid_uid' => 'PENDING_' . time(), // Temporary until first tap
        ]);

        return redirect()->back()->with('success', 'Karyawan berhasil ditambahkan. Minta karyawan untuk tap kartu RFID.');
    }

    public function destroyEmployee(Employee $employee)
    {
        if (auth()->check() && auth()->user()->role === 'employee')
            abort(403);
        $employee->delete();
        return redirect()->back()->with('success', 'Employee deleted successfully');
    }
}
