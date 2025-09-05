<?php

use Illuminate\Support\Facades\Route;
use Modules\HR\Http\Controllers\AttendanceController;
use Modules\HR\Http\Controllers\PayrollReportController;

Route::prefix('hr')->group(function () {
    Route::get('attendance', [AttendanceController::class, 'create']);
    Route::post('attendance', [AttendanceController::class, 'store'])->name('hr.attendance.store');
    Route::get('payroll/report', [PayrollReportController::class, 'monthly']);
});
