<?php

use Illuminate\Support\Facades\Route;
use Modules\Notifications\Http\Controllers\Api\NotificationController;
use Modules\Notifications\Http\Controllers\Api\PreferenceController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::post('notifications', [NotificationController::class, 'store']);
    Route::patch('notifications/preferences', [PreferenceController::class, 'update']);
});
