<?php

use Illuminate\Support\Facades\Route;
use Modules\Core\Http\Controllers\TenantController;
use Modules\Core\Http\Controllers\UserController;

Route::prefix('v1/core')->group(function () {
    Route::post('/tenants', [TenantController::class, 'store'])->middleware('throttle:10,1');
    Route::get('/users/{id}', [UserController::class, 'show'])->middleware('auth');
});
