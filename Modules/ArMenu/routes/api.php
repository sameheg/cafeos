<?php

use Illuminate\Support\Facades\Route;
use Modules\ArMenu\Http\Controllers\Api\MenuController;
use Modules\ArMenu\Http\Controllers\Api\InteractionController;

Route::prefix('v1')->group(function () {
    Route::get('ar/menu/{id}', [MenuController::class, 'show']);
    Route::post('ar/interactions', [InteractionController::class, 'store']);
});
