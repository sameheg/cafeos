<?php

use Illuminate\Support\Facades\Route;
use Modules\Kiosk\Http\Controllers\Api\OrderController;
use Modules\Kiosk\Http\Controllers\Api\StatusController;

Route::post('orders', [OrderController::class, 'store'])->middleware('throttle:100,60');
Route::get('status/{kiosk}', [StatusController::class, 'show']);
