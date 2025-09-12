<?php

use Illuminate\Support\Facades\Route;
use Modules\Energy\Http\Controllers\AnomalyController;
use Modules\Energy\Http\Controllers\LogController;

Route::prefix('v1/energy')->group(function () {
    Route::post('logs', [LogController::class, 'store'])->middleware('throttle:500,60');
    Route::get('anomalies', [AnomalyController::class, 'index']);
});
