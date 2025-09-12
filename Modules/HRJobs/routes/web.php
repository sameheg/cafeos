<?php

use Illuminate\Support\Facades\Route;
use Modules\HRJobs\Http\Controllers\HRJobsController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('hrjobs', HRJobsController::class)->names('hrjobs');
});
