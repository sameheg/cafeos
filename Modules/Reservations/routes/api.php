<?php
use Illuminate\Support\Facades\Route;
use Modules\Reservations\App\Http\Controllers\ReservationController;

Route::prefix('v1/reservations')->group(function () {
    Route::get('/', [ReservationController::class, 'index']);
    Route::post('/', [ReservationController::class, 'store']);
    Route::get('/{reservation}', [ReservationController::class, 'show']);
    Route::put('/{reservation}', [ReservationController::class, 'update']);
    Route::delete('/{reservation}', [ReservationController::class, 'destroy']);
});
