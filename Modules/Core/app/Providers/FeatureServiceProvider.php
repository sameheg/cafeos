<?php

namespace Modules\Core\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Pennant\Feature;
use Modules\Core\Models\FeatureFlag;

class FeatureServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Feature::define('core_multi_tenancy', function ($user, ?string $tenantId = null) {
            $tenantId = $tenantId ?: (app()->bound('tenant') ? app('tenant')->id : null);
            if (!$tenantId) {
                return false;
            }

            return FeatureFlag::where('tenant_id', $tenantId)
                ->where('name', 'core_multi_tenancy')
                ->value('enabled') ?? false;
        });
    }
}
