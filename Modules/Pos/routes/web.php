<?php

use Illuminate\Support\Facades\Route;
use Modules\Pos\Http\Controllers\PosController;
use Modules\Pos\Http\Controllers\WaiterController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('pos', PosController::class)->names('pos');
    Route::get('waiter', [WaiterController::class, 'index'])->name('pos.waiter');
    Route::post('waiter/orders/{order}/move', [WaiterController::class, 'move'])->name('pos.waiter.move');
    Route::post('waiter/orders/{order}/split', [WaiterController::class, 'split'])->name('pos.waiter.split');
});
