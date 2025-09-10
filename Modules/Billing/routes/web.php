<?php

use Illuminate\Support\Facades\Route;
use Modules\Billing\Http\Controllers\SubscriptionController;
use Laravel\Cashier\Http\Controllers\WebhookController;

Route::middleware('web')->group(function (): void {
    Route::get('billing/subscriptions', [SubscriptionController::class, 'index'])->name('billing.subscriptions.index');
    Route::post('billing/subscriptions/{plan}', [SubscriptionController::class, 'store'])->name('billing.subscriptions.store');
});

Route::post('stripe/webhook', [WebhookController::class, 'handleWebhook']);

