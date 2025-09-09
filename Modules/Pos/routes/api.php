<?php

use Illuminate\Support\Facades\Route;
use Modules\Pos\Http\Controllers\OrderController;
use Nwidart\Modules\Facades\Module as Modules;

if (Modules::isEnabled('Pos')) {
    Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
        Route::apiResource('orders', OrderController::class)->names('orders');
    });
}
