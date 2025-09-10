<?php

use Illuminate\Support\Facades\Route;
use Modules\EquipmentLeasing\Http\Controllers\LeaseController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::get('equipment-leasing/leases', [LeaseController::class, 'index'])->name('equipment-leasing.leases.index');
    Route::post('equipment-leasing/leases', [LeaseController::class, 'store'])->name('equipment-leasing.leases.store');
});
