<?php

use Illuminate\Support\Facades\Route;
use Modules\EquipmentMaintenance\Http\Controllers\TicketController;

Route::prefix('v1')->group(function () {
    Route::post('/maintenance/tickets', [TicketController::class, 'store'])->middleware('throttle:50,60');
    Route::patch('/maintenance/tickets/{id}/complete', [TicketController::class, 'complete']);
});
