<?php

use Illuminate\Support\Facades\Route;
use Modules\Integrations\Jobs\SyncShopifyOrdersJob;
use Modules\Integrations\Jobs\SyncWooCommerceOrdersJob;

Route::prefix('integrations')->group(function () {
    Route::post('shopify/orders', function () {
        SyncShopifyOrdersJob::dispatch();
        return response()->json(['status' => 'queued']);
    });

    Route::post('woocommerce/orders', function () {
        SyncWooCommerceOrdersJob::dispatch();
        return response()->json(['status' => 'queued']);
    });
});
