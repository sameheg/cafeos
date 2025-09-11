<?php

use Illuminate\Support\Facades\Route;
use App\Models\Tenant;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('tenant')->group(function () {
    Route::get('/tenant', function () {
        return 'Tenant: '.(Tenant::current()->name ?? 'none');
    });
});
