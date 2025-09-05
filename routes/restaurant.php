<?php

use App\Http\Controllers\Restaurant\QROrderController;
use Illuminate\Support\Facades\Route;

Route::get('tables/{table}/menu', [QROrderController::class, 'menu'])->name('qr-order.menu');
Route::get('tables/{table}/qr', [QROrderController::class, 'qr'])->name('qr-order.qr');
Route::post('tables/{table}/order', [QROrderController::class, 'order'])->name('qr-order.order');
Route::get('tables/{table}/orders', [QROrderController::class, 'orders'])->name('qr-order.orders');
Route::get('tables/{table}/orders/view', [QROrderController::class, 'view'])->name('qr-order.orders-view');
Route::post('orders/{order}/ready', [QROrderController::class, 'ready'])->name('qr-order.ready');
