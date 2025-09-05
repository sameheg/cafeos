<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ProductApiController;
use App\Http\Controllers\API\OrderApiController;
use App\Http\Controllers\Api\MenuSuggestionController;
use App\Contact;
use App\Transaction;

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
