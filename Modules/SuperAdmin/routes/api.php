<?php

use Illuminate\Support\Facades\Route;
use Modules\SuperAdmin\Http\Controllers\BroadcastController;
use Modules\SuperAdmin\Http\Controllers\ModuleController;

Route::middleware(['auth:sanctum', 'throttle:5,1'])->prefix('v1/superadmin')->group(function () {
    Route::patch('modules', [ModuleController::class, 'update']);
    Route::post('broadcasts', [BroadcastController::class, 'store']);
});
