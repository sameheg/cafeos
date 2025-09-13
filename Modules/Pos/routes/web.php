<?php

use Illuminate\Support\Facades\Route;
use Modules\Pos\Http\Controllers\PosController;
use Modules\Pos\Livewire\Tables\MapDesigner;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('pos', PosController::class)->names('pos');

    Route::view('pos/cashier', 'pos::cashier.index')
        ->name('pos.cashier')
        ->middleware('cashier');

    Route::get('pos/table-layouts/{layout}/edit', MapDesigner::class)
        ->name('pos.table-layouts.edit');

    Route::get('pos/table-layouts/{layout}', MapDesigner::class)
        ->name('pos.table-layouts.view');
});
