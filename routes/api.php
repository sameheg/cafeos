<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ProductApiController;
use App\Http\Controllers\API\OrderApiController;
use App\Http\Controllers\Api\MenuSuggestionController;
use Modules\Reporting\Services\ForecastService;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::apiResource('products', ProductApiController::class);
    Route::apiResource('orders', OrderApiController::class);
    Route::get('menu-suggestions', [MenuSuggestionController::class, 'index']);
    Route::apiResource('themes', \App\Http\Controllers\API\ThemeController::class);
});

Route::get('/analytics/realtime', function (ForecastService $service) {
    return response()->stream(function () use ($service) {
        echo 'data: ' . json_encode($service->forecast()) . "\n\n";
    }, 200, [
        'Content-Type' => 'text/event-stream',
    ]);
});
