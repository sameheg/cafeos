<?php

namespace Modules\Core\Models;

use App\Models\Concerns\BelongsToTenant;
use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
    use BelongsToTenant;

    protected $fillable = [
        'name',
        'guard_name',
        'tenant_id',
    ];
}
