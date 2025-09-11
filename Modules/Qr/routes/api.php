<?php

use Illuminate\Support\Facades\Route;
use Modules\Qr\Http\Controllers\Api\MenuController;
use Modules\Qr\Http\Controllers\Api\OrderController;

Route::get('menu/{table_id}', [MenuController::class, 'show'])->middleware('throttle:500,60');
Route::post('orders', [OrderController::class, 'store']);
