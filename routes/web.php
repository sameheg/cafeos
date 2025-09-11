<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::view('/docs/core', 'docs.core');

Route::get('/docs/openapi/modules/core.yaml', function () {
    $path = base_path('docs/openapi/modules/core.yaml');
    abort_unless(file_exists($path), 404);

    return response()->file($path);
});
