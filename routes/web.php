<?php

use Illuminate\Support\Facades\Route;
use Nwidart\Modules\Facades\Module;

Route::get('/', function () {
    return view('welcome');
});

if (Module::isEnabled('Pos')) {
    Route::middleware(['auth:sanctum', 'tenancy', 'role:owner'])->group(function () {
        Route::get('/pos', function () {
            return __('pos.enabled');
        });
    });
}
