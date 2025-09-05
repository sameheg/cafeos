<?php

use Illuminate\Support\Facades\Route;
use Modules\Superadmin\Http\Controllers\PricingController;
use Modules\Superadmin\Http\Controllers\SubscriptionController;

Route::get('pricing', [PricingController::class, 'index'])->name('pricing');
Route::post('subscribe', [SubscriptionController::class, 'subscribe'])->name('subscribe');
