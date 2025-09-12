<?php

use Illuminate\Support\Facades\Route;
use Modules\EquipmentMaintenance\Http\Controllers\EquipmentMaintenanceController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('equipmentmaintenances', EquipmentMaintenanceController::class)->names('equipmentmaintenance');
});
