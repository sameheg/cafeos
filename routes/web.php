<?php

use Illuminate\Support\Facades\Route;
use Nwidart\Modules\Facades\Module;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\ShiftController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/promotions/{user}', [PromotionController::class, 'show']);

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
});
