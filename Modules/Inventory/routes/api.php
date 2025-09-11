<?php

use Illuminate\Support\Facades\Route;
use Modules\Inventory\Http\Controllers\InventoryItemController;

Route::patch('items/{id}', [InventoryItemController::class, 'update'])
    ->middleware('throttle:50,1');

Route::get('low-stock', [InventoryItemController::class, 'lowStock']);
