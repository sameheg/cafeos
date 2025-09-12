<?php

namespace Modules\Core\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Models\Traits\BelongsToTenant;

class FeatureFlag extends Model
{
    use HasUlids, BelongsToTenant;

    protected $fillable = [
        'tenant_id',
        'name',
        'enabled',
        'cohort',
    ];

    protected $casts = [
        'enabled' => 'boolean',
        'cohort' => 'array',
    ];
}
