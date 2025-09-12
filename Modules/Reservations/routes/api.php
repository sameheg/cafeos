<?php

use Illuminate\Support\Facades\Route;
use Modules\Reservations\Http\Controllers\ReservationController;

Route::prefix('v1')->group(function () {
    Route::post('/reservations', [ReservationController::class, 'store'])->middleware('throttle:200,60');
    Route::patch('/reservations/{reservation}/checkin', [ReservationController::class, 'checkin']);
});
