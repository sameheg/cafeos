<?php

use Illuminate\Support\Facades\Route;
use Modules\TableReservations\Http\Controllers\ReservationController;
use Modules\TableReservations\Http\Controllers\WaitlistController;
use Modules\TableReservations\Http\Controllers\TableController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('tables', TableController::class);
    Route::apiResource('reservations', ReservationController::class)->only(['index','store','update']);
    Route::post('reservations/{reservation}/confirm', [ReservationController::class, 'confirm']);
    Route::apiResource('waitlist', WaitlistController::class)->only(['index','store','update']);
});
