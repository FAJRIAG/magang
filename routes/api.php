<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TapController;
use App\Http\Middleware\VerifyDeviceSignature;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/tap', [TapController::class, 'tap'])->middleware(VerifyDeviceSignature::class);
