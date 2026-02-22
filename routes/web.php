<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskSubmissionController;
use App\Http\Controllers\ConfigurationController;
use App\Http\Controllers\AccountController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/dashboard');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Admin-only routes - with role check
Route::middleware(['auth', 'verified'])->group(function () {
    // Employee Management
    Route::get('/employees', [DashboardController::class, 'employees'])->name('employees');
    Route::post('/employees', [DashboardController::class, 'storeEmployee'])->name('employees.store');
    Route::delete('/employees/{employee}', [DashboardController::class, 'destroyEmployee'])->name('employees.destroy');

    // Account Management
    Route::get('/accounts', [AccountController::class, 'index'])->name('accounts.index');
    Route::post('/accounts', [AccountController::class, 'store'])->name('accounts.store');
    Route::delete('/accounts/{user}', [AccountController::class, 'destroy'])->name('accounts.destroy');

    // Task Management
    // Task Management
    Route::group([], function () {
        Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
        Route::get('/tasks/create', [TaskController::class, 'create'])->name('tasks.create');
        Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
        Route::get('/tasks/{task}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
        Route::get('/tasks/{task}/assign', [TaskController::class, 'assign'])->name('tasks.assign');
        Route::post('/tasks/{task}/assign', [TaskController::class, 'storeAssignment'])->name('tasks.assign.store');
        Route::get('/tasks/{task}', [TaskController::class, 'show'])->name('tasks.show');
        Route::put('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
        Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
    });

    // Task Approvals
    Route::get('/submissions', [TaskSubmissionController::class, 'index'])->name('submissions.index');
    Route::post('/submissions/{submission}/approve', [TaskSubmissionController::class, 'approve'])->name('submissions.approve');
    Route::post('/submissions/{submission}/reject', [TaskSubmissionController::class, 'reject'])->name('submissions.reject');

    // Device Management
    Route::get('/devices', [DeviceController::class, 'index'])->name('devices.index');
    Route::get('/devices/create', [DeviceController::class, 'create'])->name('devices.create');
    Route::post('/devices', [DeviceController::class, 'store'])->name('devices.store');
    Route::get('/devices/{device}', [DeviceController::class, 'show'])->name('devices.show');
    Route::get('/devices/{device}/edit', [DeviceController::class, 'edit'])->name('devices.edit');
    Route::put('/devices/{device}', [DeviceController::class, 'update'])->name('devices.update');
    Route::delete('/devices/{device}', [DeviceController::class, 'destroy'])->name('devices.destroy');

    // Settings
    Route::get('/settings', [ConfigurationController::class, 'index'])->name('settings.index');
    Route::put('/settings', [ConfigurationController::class, 'update'])->name('settings.update');

    // Reward Products Management
    Route::resource('reward-products', \App\Http\Controllers\RewardProductController::class)->except(['show']);

    // Reward Exchange Management (Admin)
    Route::get('/reward-exchanges/admin', [\App\Http\Controllers\RewardExchangeAdminController::class, 'index'])->name('reward-exchanges.admin.index');
    Route::post('/reward-exchanges/admin/{exchange}/approve', [\App\Http\Controllers\RewardExchangeAdminController::class, 'approve'])->name('reward-exchanges.admin.approve');
    Route::post('/reward-exchanges/admin/{exchange}/reject', [\App\Http\Controllers\RewardExchangeAdminController::class, 'reject'])->name('reward-exchanges.admin.reject');

    // Employee-accessible routes (no role check)
    Route::get('/available-tasks', [TaskSubmissionController::class, 'availableTasks'])->name('tasks.available');
    Route::post('/submissions/{submission}/complete', [TaskSubmissionController::class, 'store'])->name('tasks.submit');

    // Employee Reward Routes
    Route::get('/employee-rewards', [\App\Http\Controllers\EmployeeRewardController::class, 'index'])->name('employee-rewards.index');
    Route::post('/employee-rewards/{product}/exchange', [\App\Http\Controllers\EmployeeRewardController::class, 'exchange'])->name('employee-rewards.exchange');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
