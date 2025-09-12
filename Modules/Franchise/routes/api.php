<?php

use Illuminate\Support\Facades\Route;
use Modules\Franchise\Http\Controllers\ReportController;
use Modules\Franchise\Http\Controllers\TemplateController;

Route::patch('/v1/franchise/templates/{template}', [TemplateController::class, 'update'])
    ->middleware('throttle:10,1');

Route::get('/v1/franchise/reports/aggregate', [ReportController::class, 'show']);
