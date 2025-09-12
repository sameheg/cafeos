<?php

use Illuminate\Support\Facades\Route;
use Modules\Training\Http\Controllers\ProgressController;

Route::prefix('v1')->group(function () {
    Route::patch('/training/progress', [ProgressController::class, 'update'])
        ->middleware('throttle:100,60');
    Route::get('/training/courses/{employee}', [ProgressController::class, 'courses']);
});
