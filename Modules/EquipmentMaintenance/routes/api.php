<?php

use Illuminate\Support\Facades\Route;
use Modules\EquipmentMaintenance\Http\Controllers\EquipmentController;
use Modules\EquipmentMaintenance\Http\Controllers\MaintenanceScheduleController;
use Modules\EquipmentMaintenance\Http\Controllers\MaintenanceLogController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::post('equipment', [EquipmentController::class, 'store'])->name('equipment.store');
    Route::post('maintenance-schedules', [MaintenanceScheduleController::class, 'store'])->name('maintenance-schedules.store');
    Route::post('maintenance-logs', [MaintenanceLogController::class, 'store'])->name('maintenance-logs.store');
});
