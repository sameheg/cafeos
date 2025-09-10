<?php

use Illuminate\Support\Facades\Route;
use Modules\Reports\Http\Controllers\ReportsController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('reports', [ReportsController::class, 'index'])->name('reports.index');
});
