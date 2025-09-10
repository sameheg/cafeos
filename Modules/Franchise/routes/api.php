<?php

use Illuminate\Support\Facades\Route;
use Modules\Franchise\Http\Controllers\FranchiseController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::get('franchises/listings', [FranchiseController::class, 'index'])->name('franchise.listings.index');
    Route::post('franchises/listings', [FranchiseController::class, 'store'])->name('franchise.listings.store');
});
