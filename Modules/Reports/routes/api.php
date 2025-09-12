<?php

use Illuminate\Support\Facades\Route;
use Modules\Reports\Http\Controllers\ReportController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::get('reports/{id}', [ReportController::class, 'show'])->middleware('throttle:30,1');
    Route::post('reports/schedule', [ReportController::class, 'schedule']);
});
