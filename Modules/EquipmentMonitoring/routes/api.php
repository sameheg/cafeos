<?php

use Illuminate\Support\Facades\Route;
use Modules\EquipmentMonitoring\Http\Controllers\DeviceController;
use Modules\EquipmentMonitoring\Http\Controllers\ReadingController;

Route::prefix('equipment-monitoring')->group(function () {
    Route::get('devices', [DeviceController::class, 'index']);
    Route::post('devices', [DeviceController::class, 'store']);
    Route::post('devices/{device}/readings', [ReadingController::class, 'store']);
});
