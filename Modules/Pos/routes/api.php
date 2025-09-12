<?php
use Illuminate\Support\Facades\Route;
use Modules\Pos\App\Http\Controllers\Api\TableController;
use Modules\Pos\App\Http\Controllers\Api\PaymentController;
use Modules\Pos\App\Http\Controllers\Api\RefundController;
use Modules\Pos\App\Http\Controllers\Api\OfflineSyncController;
use Modules\Pos\App\Http\Controllers\Api\HardwareController;
use Modules\Reservations\App\Http\Middleware\ReservationGuardMiddleware;

Route::prefix('v1/pos')->group(function () {
    Route::post('/tables/start', [TableController::class, 'startOrder'])
        ->middleware(ReservationGuardMiddleware::class);

    Route::post('/orders/{order}/items', [TableController::class, 'addItem']);
    Route::post('/orders/{order}/pay', [PaymentController::class, 'pay']);
    Route::post('/orders/{order}/refund', [RefundController::class, 'refund']);

    Route::post('/offline/sync', [OfflineSyncController::class, 'sync']);

    Route::post('/hardware/print', [HardwareController::class, 'printReceipt']);
    Route::post('/hardware/drawer', [HardwareController::class, 'openDrawer']);
});
