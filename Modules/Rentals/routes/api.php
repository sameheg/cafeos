<?php

use Illuminate\Support\Facades\Route;
use Modules\Rentals\Http\Controllers\ListingController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::get('rentals/listings', [ListingController::class, 'index'])->name('rentals.listings.index');
    Route::post('rentals/listings', [ListingController::class, 'store'])->name('rentals.listings.store');
});
