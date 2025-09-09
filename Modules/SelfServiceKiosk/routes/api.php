<?php

use Illuminate\Support\Facades\Route;
use Modules\SelfServiceKiosk\Http\Controllers\KioskOrderController;

Route::post('order', [KioskOrderController::class, 'store']);
