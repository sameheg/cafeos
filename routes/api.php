<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ProductApiController;
use App\Http\Controllers\API\OrderApiController;
use App\Http\Controllers\API\RecipeApiController;
use App\Http\Controllers\Api\MenuSuggestionController;
use App\Http\Controllers\API\KdsMetricsController;
use Modules\Reporting\Services\ForecastService;
use App\Contact;
use App\Transaction;
use Modules\Inventory\Http\Controllers\InventoryApiController;

require_once base_path('agents/agent-kds/src/KdsMetrics.php');
require_once base_path('agents/agent-kds/src/KdsService.php');
require_once base_path('agents/agent-kds/src/AuthService.php');
require_once base_path('agents/agent-kds/src/Roles.php');
require_once base_path('agents/agent-kds/src/TicketEndpoint.php');

$kdsMetrics = new KdsMetrics();
$kdsService = new KdsService($kdsMetrics);
$kdsAuth = new AuthService(env('KDS_TOKEN', 'secret'));
$ticketEndpoint = new TicketEndpoint($kdsService, $kdsAuth);

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

Route::get('/kds/metrics', [KdsMetricsController::class, 'index']);

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

Route::get('/kds/tickets', function (Request $request) use ($kdsService, $kdsAuth) {
    $token = $request->bearerToken() ?? '';
    if (! $kdsAuth->validate($token, [Roles::CHEF, Roles::KITCHEN_MANAGER])) {
        abort(403);
    }

    $tickets = array_map(
        static fn (array $t): array => [
            'id' => $t['id'],
            'status' => $t['status'],
            'preparation_time' => $t['preparation_time'],
        ],
        $kdsService->getActiveTickets()
    );

    return ['tickets' => $tickets];
});

Route::post('/kds/tickets/{ticket}/status', function (int $ticket, Request $request) use ($ticketEndpoint, $kdsAuth) {
    $token = $request->bearerToken() ?? '';
    if (! $kdsAuth->validate($token, [Roles::CHEF, Roles::KITCHEN_MANAGER])) {
        abort(403);
    }

    $data = $request->validate([
        'status' => 'required|string',
    ]);

    $response = $ticketEndpoint->update($ticket, $data['status']);
    $t = $response['ticket'] ?? null;
    if ($t === null) {
        abort(404);
    }

    return [
        'id' => $t['id'],
        'status' => $t['status'],
        'preparation_time' => $t['preparation_time'],
    ];
});
