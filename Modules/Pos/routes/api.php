<?php

use Illuminate\Support\Facades\Route;

// API routes for the Pos module can be defined here when needed.
use Modules\Pos\Http\Controllers\PosController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('pos', PosController::class)->names('pos');
});
