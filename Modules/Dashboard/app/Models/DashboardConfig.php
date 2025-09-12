<?php

namespace Modules\Dashboard\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Modules\Core\Models\Traits\BelongsToTenant;

class DashboardConfig extends Model
{
    use HasFactory, HasUlids, BelongsToTenant;

    protected $fillable = [
        'tenant_id',
        'user_id',
        'widgets',
    ];

    protected $casts = [
        'widgets' => 'array',
    ];
}
