<?php

use Illuminate\Support\Facades\Route;
use Modules\Kds\Http\Controllers\Api\TicketController;

Route::prefix('v1/kds')->middleware('api')->group(function () {
    Route::post('tickets', [TicketController::class, 'store']);
    Route::patch('tickets/{id}/bump', [TicketController::class, 'bump']);
});
