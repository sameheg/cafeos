<?php

use Illuminate\Support\Facades\Route;
use Modules\Core\Http\Controllers\FeatureFlagController;
use Modules\Core\Http\Controllers\InvitationController;
use Modules\Core\Http\Controllers\MetricsController;
use Modules\Core\Http\Controllers\ModuleController;
use Modules\Core\Http\Controllers\SettingsController;
use Modules\Core\Http\Controllers\TenantController;

Route::prefix('v1')->group(function () {
    Route::middleware(['resolve-tenant', 'set-locale-from-tenant', 'subscription-gate', 'audit'])->group(function () {
        Route::get('/healthz', function () {
            return response()->json([
                'status' => 'ok',
                'message' => __('core::health.ok'),
            ]);
        });

        Route::get('/modules', [ModuleController::class, 'index']);
        Route::post('/modules/{name}/toggle', [ModuleController::class, 'toggle']);
        Route::get('/settings', [SettingsController::class, 'index']);
        Route::put('/settings', [SettingsController::class, 'update']);
        Route::get('/feature-flags', [FeatureFlagController::class, 'index']);
        Route::put('/feature-flags/{key}', [FeatureFlagController::class, 'update']);
        Route::get('/rbac-ping', fn () => ['status' => 'ok'])->middleware('role:owner');
        Route::post('/invitations', [InvitationController::class, 'store']);
        Route::post('/invitations/accept', [InvitationController::class, 'accept']);
    });

    Route::get('/tenants', [TenantController::class, 'index']);
    Route::post('/tenants', [TenantController::class, 'store']);
    Route::get('/metrics', MetricsController::class);
});
