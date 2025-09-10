<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Builder;

trait PreloadsRelations
{
    protected array $preload = [];

    public function scopeWithPreload(Builder $query): Builder
    {
        return $query->with($this->preload);
    }
}
