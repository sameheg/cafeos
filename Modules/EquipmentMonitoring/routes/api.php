<?php

use Illuminate\Support\Facades\Route;
use Modules\EquipmentMonitoring\Http\Controllers\AlertController;
use Modules\EquipmentMonitoring\Http\Controllers\DataController;

Route::prefix('v1/monitoring')->group(function () {
    Route::post('/data', [DataController::class, 'store'])->middleware('throttle:1000,60');
    Route::get('/alerts', [AlertController::class, 'index']);
});
