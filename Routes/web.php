<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Pos\CashierController;
use App\Http\Controllers\Pos\KdsController;
use App\Http\Controllers\Pos\TableController;
use App\Http\Controllers\Pos\PaymentController;
use App\Http\Controllers\Pos\ReservationController;

Route::middleware(['auth', 'tenant'])
    ->prefix('pos')
    ->name('pos.')
    ->group(function () {
        Route::get('/cashier', [CashierController::class, 'index'])->name('cashier');
        Route::get('/kds', [KdsController::class, 'index'])->name('kds');
        Route::get('/tables', [TableController::class, 'index'])->name('tables');
        Route::post('/tables', [TableController::class, 'store'])->name('tables.store');
        Route::get('/payments', [PaymentController::class, 'index'])->name('payments');
        Route::post('/payments', [PaymentController::class, 'store'])->name('payments.store');
        Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations');
        Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');
    });
