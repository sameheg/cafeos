<?php

namespace Modules\Core\Models;

use Spatie\Permission\Models\Permission as SpatiePermission;
use App\Models\Concerns\BelongsToTenant;

class Permission extends SpatiePermission
{
    use BelongsToTenant;

    protected $fillable = [
        'name',
        'guard_name',
        'tenant_id',
    ];
}
