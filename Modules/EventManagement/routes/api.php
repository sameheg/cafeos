<?php

use Illuminate\Support\Facades\Route;
use Modules\EventManagement\Http\Controllers\TicketController;
use Modules\EventManagement\Http\Controllers\WaitlistController;

Route::post('tickets', [TicketController::class, 'store'])->middleware('throttle:100,1');
Route::get('{event}/waitlist', [WaitlistController::class, 'show']);
