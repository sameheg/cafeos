<?php

namespace App\Filament\Resources\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Schema;

trait TenantScoped
{
    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        if (! auth()->user()?->hasRole('Super Admin') && tenant()) {
            $model = static::$model;
            $instance = new $model;
            $table = $instance->getTable();

            if (Schema::hasTable($table) && Schema::hasColumn($table, 'tenant_id')) {
                $query->where('tenant_id', tenant('id'));
            }
        }

        return $query;
    }
}
