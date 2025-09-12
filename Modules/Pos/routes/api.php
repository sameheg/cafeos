<?php

use Illuminate\Support\Facades\Route;
use Modules\Pos\Http\Controllers\Api\OrderController;

Route::prefix('v1/pos')->middleware('api')->group(function () {
    Route::post('orders', [OrderController::class, 'store']);
    Route::get('orders/{id}', [OrderController::class, 'show']);
});


use Modules\Pos\Http\Controllers\Api\TableController;

Route::prefix('table')->group(function(){
    Route::get('/{table}', [TableController::class,'show']);
    Route::post('/{table}/order/start',[TableController::class,'startOrder']);
    Route::post('/order/{order}/items',[TableController::class,'addItem']);
    Route::patch('/order/{order}/close',[TableController::class,'closeOrder']);
});


use Modules\Pos\Http\Controllers\Api\CustomerController;
use Modules\Pos\Http\Controllers\Api\PaymentController;
use Modules\Pos\Http\Controllers\Api\DiscountController;
use Modules\Pos\Http\Controllers\Api\RefundController;
use Modules\Pos\Http\Controllers\Api\ReportController;

Route::prefix('pos')->group(function(){
    Route::get('/customers', [CustomerController::class,'index']);
    Route::post('/customers', [CustomerController::class,'store']);

    Route::post('/order/{order}/pay', [PaymentController::class,'pay']);
    Route::post('/order/{order}/discount', [DiscountController::class,'apply']);
    Route::post('/order/{order}/refund', [RefundController::class,'refund']);

    Route::get('/reports/daily', [ReportController::class,'daily']);
    Route::get('/reports/top-items', [ReportController::class,'topItems']);
});


use Modules\Pos\Http\Controllers\Api\BillController;
use Modules\Pos\Http\Controllers\Api\KitchenController;
use Modules\Pos\Http\Controllers\Api\ModifierController;
use Modules\Pos\Http\Controllers\Api\AuditController;
use Modules\Pos\Http\Controllers\Api\OfflineSyncController;

Route::prefix('pos')->group(function(){
    // Bills / Split bills
    Route::get('/order/{order}/bills', [BillController::class,'index']);
    Route::post('/order/{order}/bills', [BillController::class,'create']);
    Route::post('/order/{order}/bills/{bill}/items', [BillController::class,'addItem']);

    // Kitchen statuses
    Route::patch('/item/{item}/kitchen/{status}', [KitchenController::class,'setStatus']);

    // Item modifiers
    Route::post('/item/{item}/modifiers', [ModifierController::class,'add']);

    // Audit log
    Route::get('/audits', [AuditController::class,'index']);

    // Offline sync
    Route::post('/offline/token', [OfflineSyncController::class,'token']);
    Route::post('/offline/push', [OfflineSyncController::class,'push']);
});


use Modules\Pos\Http\Controllers\Api\DeliveryController;
use Modules\Pos\Http\Controllers\Api\PromotionController;
use Modules\Pos\Http\Controllers\Api\HardwareController;
use Modules\Pos\Http\Controllers\Api\ObservabilityController;
use Modules\Pos\Http\Controllers\Api\AdvancedReportController;

Route::prefix('pos')->group(function(){
    // Delivery
    Route::post('/order/{order}/delivery/assign', [DeliveryController::class,'assignDriver']);
    Route::patch('/order/{order}/delivery/{status}', [DeliveryController::class,'setStatus']);

    // Promotions
    Route::get('/promotions', [PromotionController::class,'list']);
    Route::post('/order/{order}/promotions/apply', [PromotionController::class,'apply']);

    // Hardware
    Route::post('/order/{order}/print/{printer}', [HardwareController::class,'printReceipt']);
    Route::post('/drawer/{printer}/open', [HardwareController::class,'openDrawer']);

    // Observability
    Route::get('/health', [ObservabilityController::class,'health']);
    Route::get('/metrics', [ObservabilityController::class,'metrics']);

    // Advanced Reports
    Route::get('/reports/pnl', [AdvancedReportController::class,'pnl']);
    Route::get('/reports/occupancy', [AdvancedReportController::class,'occupancy']);
});
