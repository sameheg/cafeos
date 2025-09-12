<?php

use Illuminate\Support\Facades\Route;
use Modules\Dashboard\Http\Controllers\KpiController;

Route::middleware(['auth:sanctum'])
    ->prefix('v1/dashboard')
    ->group(function () {
        Route::get('kpis', [KpiController::class, 'kpis'])->middleware('throttle:60,1');
        Route::patch('customize', [KpiController::class, 'customize']);
    });
