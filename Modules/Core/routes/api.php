<?php

use Illuminate\Support\Facades\Route;
use Modules\Core\Http\Controllers\TenantController;
use Modules\Core\Http\Controllers\UserController;
use Modules\Core\Http\Controllers\ModuleToggleController;

Route::prefix('v1/core')->group(function () {
    Route::post('/tenants', [TenantController::class, 'store'])->middleware('throttle:10,1');
    Route::get('/users/{id}', [UserController::class, 'show'])->middleware('auth');
});

Route::middleware(['auth', 'throttle:5,1'])->prefix('v1/admin')->group(function () {
    Route::patch('/modules/{module}', [ModuleToggleController::class, 'update']);
});
