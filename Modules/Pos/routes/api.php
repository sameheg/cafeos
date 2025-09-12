<?php
use Illuminate\Support\Facades\Route;
use Modules\Pos\App\Http\Controllers\OrderController;
use Modules\Pos\App\Http\Controllers\PaymentController;
use Modules\Pos\App\Http\Controllers\TableController;
use Modules\Reservations\App\Http\Middleware\ReservationGuardMiddleware;

Route::prefix('v1/pos')->group(function () {
    Route::post('/tables/start', [TableController::class, 'startOrder'])
        ->middleware(ReservationGuardMiddleware::class);

    Route::post('/orders/{order}/items', [OrderController::class, 'addItem']);
    Route::post('/orders/{order}/void', [OrderController::class, 'void']);
    Route::post('/orders/{order}/pay', [PaymentController::class, 'pay']);
});
