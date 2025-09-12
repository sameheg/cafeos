<?php
use Illuminate\Support\Facades\Route;
use Modules\Pos\App\Http\Controllers\OrderController;
use Modules\Pos\App\Http\Controllers\PaymentController;
use Modules\Reservations\App\Http\Middleware\ReservationGuardMiddleware;

Route::prefix('v1/pos')->group(function () {
    // فحص الحجز قبل فتح الطلب
    Route::post('/orders/open', [OrderController::class, 'open'])
        ->middleware(ReservationGuardMiddleware::class);

    Route::post('/orders/{order}/items', [OrderController::class, 'addItem']);
    Route::post('/orders/{order}/void', [OrderController::class, 'void']);

    // الدفع
    Route::post('/orders/{order}/pay', [PaymentController::class, 'pay']);
});
