<?php

use Illuminate\Support\Facades\Route;
use Modules\FoodSafety\Http\Controllers\LogController;

Route::post('/logs', [LogController::class, 'store'])
    ->middleware('throttle:200,60')
    ->name('logs.store');

Route::get('/incidents', [LogController::class, 'incidents'])
    ->name('incidents.index');
