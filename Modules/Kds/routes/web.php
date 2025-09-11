<?php

use Illuminate\Support\Facades\Route;
use Modules\Kds\Http\Controllers\KdsController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('kds', KdsController::class)->names('kds');
});
