<?php

use Illuminate\Support\Facades\Route;
use Modules\Notifications\Http\Controllers\NotificationController;

Route::prefix('notifications')->group(function () {
    Route::get('/', [NotificationController::class, 'index']);
    Route::post('{notification}/acknowledge', [NotificationController::class, 'acknowledge']);
    Route::post('{notification}/escalate', [NotificationController::class, 'escalate']);
});
