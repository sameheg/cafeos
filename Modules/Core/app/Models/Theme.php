<?php

namespace Modules\Core\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Models\Traits\BelongsToTenant;

class Theme extends Model
{
    use HasUlids, BelongsToTenant;

    protected $fillable = [
        'logo_path',
        'colors',
        'rtl',
    ];

    protected $casts = [
        'colors' => 'array',
        'rtl' => 'boolean',
    ];
}
