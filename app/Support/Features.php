<?php

namespace App\Support;

use App\Models\TenantModule;
use Illuminate\Support\Facades\Cache;

class Features
{
    public function enabled(string $module): bool
    {
        $tenantId = tenant('id');

        if (!$tenantId) {
            return false;
        }

        return Cache::remember("features.{$tenantId}.{$module}", 60, function () use ($tenantId, $module) {
            return TenantModule::where('tenant_id', $tenantId)
                ->where('module', $module)
                ->value('enabled') ?? false;
        });
    }
}

if (! function_exists('features')) {
    function features(): Features
    {
        return app(Features::class);
    }
}
