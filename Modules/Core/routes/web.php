<?php

use Illuminate\Support\Facades\Route;

Route::prefix('v1')->middleware(['resolve-tenant', 'set-locale-from-tenant'])->group(function () {
    Route::get('/ping', fn () => 'ok');
});
