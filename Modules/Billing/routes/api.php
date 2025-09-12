<?php

use Illuminate\Support\Facades\Route;
use Modules\Billing\Http\Controllers\InvoiceController;

Route::post('invoices', [InvoiceController::class, 'store'])
    ->middleware('throttle:20,1');

Route::get('history/{tenant_id}', [InvoiceController::class, 'history']);
