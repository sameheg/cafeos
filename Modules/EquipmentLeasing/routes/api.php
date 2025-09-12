<?php

use Illuminate\Support\Facades\Route;
use Modules\EquipmentLeasing\Http\Controllers\LeaseController;

Route::prefix('v1/equipment')->group(function () {
    Route::post('leases', [LeaseController::class, 'store'])->name('equipment.leases.store');
    Route::get('uptime/{lease}', [LeaseController::class, 'uptime'])->name('equipment.leases.uptime');
});

