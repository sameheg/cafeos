<?php

use Illuminate\Support\Facades\Route;
use Modules\EquipmentMonitoring\Http\Controllers\DashboardController;

Route::get('equipment-monitoring/dashboard', [DashboardController::class, 'index']);
