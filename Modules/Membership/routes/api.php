<?php

use Illuminate\Support\Facades\Route;
use Modules\Membership\Http\Controllers\Api\MembershipController;
use Modules\Membership\Http\Controllers\Api\PerkController;

Route::prefix('v1')->group(function () {
    Route::patch('membership/{membership}', [MembershipController::class, 'update']);
    Route::get('membership/perks/{tier}', [PerkController::class, 'show']);
});
