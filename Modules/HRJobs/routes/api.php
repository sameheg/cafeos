<?php

use Illuminate\Support\Facades\Route;
use Modules\HRJobs\Http\Controllers\PayrollController;
use Modules\HRJobs\Http\Controllers\ShiftController;

Route::prefix('v1/hr')->group(function () {
    Route::post('shifts', [ShiftController::class, 'store'])->middleware('throttle:50,60');
    Route::post('shifts/{shift}/checkin', [ShiftController::class, 'checkin']);
    Route::get('payroll/{period}', [PayrollController::class, 'show']);
});
