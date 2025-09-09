<?php

use Illuminate\Support\Facades\Route;
use Modules\Marketplace\Http\Controllers\OrderController;
use Modules\Marketplace\Http\Controllers\ProductController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::get('marketplace/products', [ProductController::class, 'index'])->name('marketplace.products.index');
    Route::post('marketplace/products', [ProductController::class, 'store'])->name('marketplace.products.store');
    Route::post('marketplace/products/{product}/purchase', [OrderController::class, 'store'])->name('marketplace.orders.store');
});
