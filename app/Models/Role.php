<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Multitenancy\Models\Concerns\BelongsToTenant;
use Spatie\Multitenancy\Models\Concerns\UsesTenantConnection;

class Role extends Model
{
    use UsesTenantConnection, BelongsToTenant;

    protected $fillable = [
        'name',
    ];
}
