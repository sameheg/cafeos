<?php

use Illuminate\Support\Facades\Route;
use Modules\QrOrdering\Http\Controllers\QrOrderingController;

Route::post('order', [QrOrderingController::class, 'placeOrder']);
Route::post('order/{order}/approve', [QrOrderingController::class, 'approve']);
