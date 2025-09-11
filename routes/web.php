<?php

use Illuminate\Support\Facades\Route;
use App\Models\Tenant;

Route::get('/', function () {
    $tenant = app(Tenant::class);
    return 'Tenant: ' . ($tenant->name ?? 'unknown');
});
