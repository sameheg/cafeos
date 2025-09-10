<?php

use Illuminate\Support\Facades\Route;
use Modules\HrJobs\Http\Controllers\ApplicationController;
use Modules\HrJobs\Http\Controllers\JobController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('hr-jobs', JobController::class)->only(['index', 'store', 'show']);
    Route::post('hr-jobs/{job}/apply', [ApplicationController::class, 'store'])->name('hrjobs.apply');
    Route::get('applications/{application}', [ApplicationController::class, 'show'])->name('hrjobs.applications.show');
    Route::patch('applications/{application}', [ApplicationController::class, 'update'])->name('hrjobs.applications.update');
});
