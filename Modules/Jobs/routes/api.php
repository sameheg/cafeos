<?php

use Illuminate\Support\Facades\Route;
use Modules\Jobs\Http\Controllers\ApplicationController;
use Modules\Jobs\Http\Controllers\PostingsController;

Route::post('applications', [ApplicationController::class, 'store'])
    ->middleware('throttle:20,1');

Route::get('postings', [PostingsController::class, 'index']);
