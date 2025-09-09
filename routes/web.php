<?php

use Illuminate\Support\Facades\Route;
use Nwidart\Modules\Facades\Module;

Route::get('/', function () {
    return view('welcome');
});

if (Module::isEnabled('Pos')) {
    Route::get('/pos', function () {
        return 'POS module is enabled';
    });
}
