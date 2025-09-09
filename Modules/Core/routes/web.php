<?php

use Illuminate\Support\Facades\Route;
use Modules\Core\Http\Controllers\Admin\TenantController;
use Modules\Core\Http\Controllers\CoreController;
use Modules\Core\Http\Controllers\TenantSwitchController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('cores', CoreController::class)->names('core');
    Route::post('tenant/switch', TenantSwitchController::class)->name('tenant.switch');
    Route::get('admin/tenants', [TenantController::class, 'index'])->name('admin.tenants.index');
});
