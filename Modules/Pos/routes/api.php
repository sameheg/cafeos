<?php

use Illuminate\Support\Facades\Route;
use Modules\Pos\Http\Controllers\Api\OrderController;

Route::prefix('v1/pos')->middleware('api')->group(function () {
    Route::post('orders', [OrderController::class, 'store']);
    Route::get('orders/{id}', [OrderController::class, 'show']);
});
