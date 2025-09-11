<?php

namespace Modules\Core\Models\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Models\Tenant;

trait BelongsToTenant
{
    protected static function bootBelongsToTenant(): void
    {
        static::creating(function (Model $model) {
            $tenant = app()->bound('currentTenant') ? app('currentTenant') : null;
            if ($tenant) {
                $model->tenant_id = $tenant->id;
            }
        });

        static::addGlobalScope('tenant', function (Builder $builder) {
            $tenant = app()->bound('currentTenant') ? app('currentTenant') : null;
            if ($tenant) {
                $builder->where($builder->getModel()->getTable().'.tenant_id', $tenant->id);
            }
        });
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }
}
