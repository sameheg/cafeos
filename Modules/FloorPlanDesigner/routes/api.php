<?php

use Illuminate\Support\Facades\Route;
use Modules\FloorPlanDesigner\Http\Controllers\FloorplanController;

Route::patch('/{floorplan}', [FloorplanController::class, 'update'])
    ->middleware('throttle:5,1')
    ->name('update');

Route::get('/heatmap/{floorplan}', [FloorplanController::class, 'heatmap'])
    ->name('heatmap');
