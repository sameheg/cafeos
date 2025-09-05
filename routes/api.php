<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ProductApiController;
use App\Http\Controllers\API\OrderApiController;
use App\Http\Controllers\API\RecipeApiController;
use App\Http\Controllers\Api\MenuSuggestionController;
use Modules\Reporting\Services\ForecastService;
use App\Contact;
use App\Transaction;
use Modules\Inventory\Http\Controllers\InventoryApiController;

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
    Route::post('catalog/recipes/sync', [RecipeApiController::class, 'sync']);
    Route::get('catalog/recipes', [RecipeApiController::class, 'index']);
    Route::get('catalog/recipes/{product}', [RecipeApiController::class, 'show']);
});

Route::get('/analytics/realtime', function (ForecastService $service) {
    return response()->stream(function () use ($service) {
        echo 'data: ' . json_encode($service->forecast()) . "\n\n";
    }, 200, [
        'Content-Type' => 'text/event-stream',
    ]);
});

Route::middleware('customer.auth')->group(function () {
    Route::get('/customer/points', function (Request $request) {
        $contact = Contact::find($request->attributes->get('customer_id'));
        return ['points' => $contact->total_rp ?? 0];
    });

    Route::get('/customer/orders', function (Request $request) {
        $orders = Transaction::where('contact_id', $request->attributes->get('customer_id'))
            ->select('id', 'invoice_no', 'final_total', 'created_at')
            ->orderByDesc('created_at')
            ->get();
        return ['orders' => $orders];
    });
});


Route::middleware('api.token')->group(function () {
    Route::post('inventory/movements', [InventoryApiController::class, 'recordMovement']);
    Route::get('inventory/levels', [InventoryApiController::class, 'levels']);
});

Route::get('/kds/tickets', function () {
    return ['tickets' => [
        ['id' => 1, 'items' => ['Coffee', 'Bagel']],
        ['id' => 2, 'items' => ['Tea']]
    ]];
});

Route::post('/kds/tickets/{ticket}/status', function ($ticket) {
    return ['status' => 'ok'];
});
