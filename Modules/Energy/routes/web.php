<?php

use Illuminate\Support\Facades\Route;
use Modules\Energy\Http\Controllers\EnergyController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('energies', EnergyController::class)->names('energy');
});
