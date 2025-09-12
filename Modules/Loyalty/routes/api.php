<?php

use Illuminate\Support\Facades\Route;
use Modules\Loyalty\Http\Controllers\Api\LoyaltyController;

Route::prefix('v1/loyalty')->group(function () {
    Route::post('/redeem', [LoyaltyController::class, 'redeem']);
    Route::get('/balance/{customer_id}', [LoyaltyController::class, 'balance']);
});
