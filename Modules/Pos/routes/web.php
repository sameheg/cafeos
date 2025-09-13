<?php

use Illuminate\Support\Facades\Route;
use Modules\Pos\Http\Controllers\PosController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('pos', PosController::class)->names('pos');

    Route::view('pos/cashier', 'pos::cashier.index')
        ->name('pos.cashier')
        ->middleware('cashier');
});
