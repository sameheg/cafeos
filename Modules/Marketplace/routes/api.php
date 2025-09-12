<?php

use Illuminate\Support\Facades\Route;
use Modules\Marketplace\Http\Controllers\BidController;
use Modules\Marketplace\Http\Controllers\StoreController;

Route::post('bids', [BidController::class, 'store'])->middleware('throttle:50,60');
Route::get('stores/{supplier_id}', [StoreController::class, 'show']);

