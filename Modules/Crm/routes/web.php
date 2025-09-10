<?php

use Illuminate\Support\Facades\Route;
use Modules\Crm\Http\Controllers\CrmController;
use Modules\Crm\Http\Controllers\NpsController;
use Modules\Crm\Http\Controllers\SurveyController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('crms', CrmController::class)->names('crm');
    Route::post('surveys', [SurveyController::class, 'store'])->name('surveys.store');
    Route::post('surveys/{survey}/responses', [SurveyController::class, 'respond'])->name('surveys.respond');
    Route::get('branches/{branch}/nps', [NpsController::class, 'show'])->name('nps.show');
});
