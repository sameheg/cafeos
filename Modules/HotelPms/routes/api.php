<?php

use Illuminate\Support\Facades\Route;
use Modules\HotelPms\Http\Controllers\Api\FolioController;
use Modules\HotelPms\Http\Controllers\Api\ReservationSyncController;

Route::prefix('v1/pms')->group(function () {
    Route::post('folios', [FolioController::class, 'store'])->middleware('throttle:50,1');
    Route::get('sync/reservations', [ReservationSyncController::class, 'index']);
});
