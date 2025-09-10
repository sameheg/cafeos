<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Builder;

trait BelongsToTenant
{
    use PreloadsRelations;

    protected static function bootBelongsToTenant(): void
    {
        static::addGlobalScope('tenant', function (Builder $builder): void {
            if ($tenant = self::resolveTenant()) {
                $builder->where($builder->getModel()->getTable().'.tenant_id', $tenant->id);
            }
        });

        static::saving(function ($model): void {
            if ($tenant = self::resolveTenant()) {
                $model->tenant_id ??= $tenant->id;
            }
        });
    }

    private static function resolveTenant(): ?object
    {
        if (app()->bound('tenant')) {
            return app('tenant');
        }

        if (function_exists('tenant')) {
            try {
                return tenant();
            } catch (\Throwable) {
                // Ignore resolution errors and fall back to null
            }
        }

        return null;
    }
}
