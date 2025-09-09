<?php

use Illuminate\Support\Facades\Route;
use Modules\QrOrdering\Http\Controllers\QrOrderingController;

Route::get('menu', [QrOrderingController::class, 'menu']);
