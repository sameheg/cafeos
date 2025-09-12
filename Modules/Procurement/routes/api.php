<?php

use Illuminate\Support\Facades\Route;
use Modules\Procurement\Http\Controllers\PoController;
use Modules\Procurement\Http\Controllers\RfqController;

Route::post('/rfqs', [RfqController::class, 'store'])->middleware('throttle:20,1')->name('rfqs.store');
Route::post('/pos/{rfq}', [PoController::class, 'store'])->name('pos.store');
