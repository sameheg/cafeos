<?php

use Illuminate\Support\Facades\Route;
use Modules\Reservations\Http\Controllers\ReservationsController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('reservations', ReservationsController::class)->names('reservations');
});
