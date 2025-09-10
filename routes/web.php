<?php

use App\Http\Controllers\DriverLocationController;
use App\Http\Controllers\Auth\MfaController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\ShiftController;
use Illuminate\Support\Facades\Route;
use Nwidart\Modules\Facades\Module;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/promotions/{user}', [PromotionController::class, 'show']);

Route::view('/driver', 'driver.index');
Route::post('/driver/location', [DriverLocationController::class, 'update']);

if (Module::isEnabled('Pos')) {
    Route::middleware(['auth:sanctum', 'tenancy', 'role:owner'])->group(function () {
        Route::get('/pos', function () {
            return __('pos::enabled');
        });
    });
}

Route::middleware(['auth'])->group(function () {
    Route::post('/manager/shifts/assign', [ShiftController::class, 'assign']);
    Route::post('/manager/shifts/swap', [ShiftController::class, 'swap']);
    Route::post('/mfa/challenge', [MfaController::class, 'challenge'])->name('mfa.challenge');
    Route::post('/mfa/verify', [MfaController::class, 'verify'])->name('mfa.verify');
});
