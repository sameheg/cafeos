<?php

namespace App\Traits;

use App\Scopes\TenantScope;

trait HasTenant
{
    protected static function bootHasTenant()
    {
        static::addGlobalScope(new TenantScope);

        static::creating(function ($model) {
            if (app()->bound('tenant')) {
                $model->tenant_id = app('tenant')->id;
            }
        });
    }

    public function tenant()
    {
        return $this->belongsTo(\App\Tenant::class);
    }
}
