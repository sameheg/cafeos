<?php

namespace Modules\Dashboard\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Modules\Core\Models\Traits\BelongsToTenant;

class DashboardCache extends Model
{
    use HasFactory, HasUlids, BelongsToTenant;

    public $timestamps = false;

    protected $fillable = [
        'tenant_id',
        'key',
        'value',
        'expiry',
    ];

    protected $casts = [
        'value' => 'array',
        'expiry' => 'datetime',
    ];
}
