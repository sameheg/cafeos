<?php

use Illuminate\Support\Facades\Route;
use Nwidart\Modules\Facades\Module;
use App\Http\Controllers\PromotionController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/promotions/{user}', [PromotionController::class, 'show']);

if (Module::isEnabled('Pos')) {
        Route::middleware(['auth:sanctum', 'tenancy', 'role:owner'])->group(function () {
        Route::get('/pos', function () {
            return __('pos::enabled');
        });
    });
}
