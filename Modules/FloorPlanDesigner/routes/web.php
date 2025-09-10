<?php

use Illuminate\Support\Facades\Route;
use Modules\FloorPlanDesigner\Http\Controllers\FloorPlanController;

Route::middleware('web')->group(function () {
    Route::get('floor-plan', [FloorPlanController::class, 'index'])->name('floor-plan.index');
    Route::post('floor-plan', [FloorPlanController::class, 'store'])->name('floor-plan.store');
});
