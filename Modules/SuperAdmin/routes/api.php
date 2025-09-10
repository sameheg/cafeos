<?php

use Illuminate\Support\Facades\Route;
use Modules\Billing\Http\Controllers\PlanController;
use Modules\Billing\Http\Controllers\SubscriptionController;
use Modules\SuperAdmin\Http\Controllers\ModuleController;

Route::middleware(['auth:sanctum'])->prefix('v1/super-admin')->group(function () {
    Route::get('plans', [PlanController::class, 'index'])->name('superadmin.plans.index');
    Route::get('subscriptions', [SubscriptionController::class, 'index'])->name('superadmin.subscriptions.index');
    Route::get('modules', [ModuleController::class, 'index'])->name('superadmin.modules.index');
    Route::patch('modules/{module}', [ModuleController::class, 'update'])->name('superadmin.modules.update');
});
