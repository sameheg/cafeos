<?php

use Illuminate\Support\Facades\Route;
use Modules\Crm\Http\Controllers\CrmController;
use Modules\Crm\Http\Controllers\CustomerTierController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('crms', CrmController::class)->names('crm');
    Route::post('customers/{customer}/tier/upgrade', [CustomerTierController::class, 'upgrade']);
    Route::post('customers/{customer}/tier/downgrade', [CustomerTierController::class, 'downgrade']);
});
