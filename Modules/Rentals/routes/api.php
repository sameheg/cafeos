<?php

use Illuminate\Support\Facades\Route;
use Modules\Rentals\Http\Controllers\ContractController;
use Modules\Rentals\Http\Controllers\OccupancyController;

Route::post('contracts', [ContractController::class, 'store'])
    ->middleware('throttle:10,1');

Route::get('occupancy', [OccupancyController::class, 'show']);
