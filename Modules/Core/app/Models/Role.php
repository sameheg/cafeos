<?php

namespace Modules\Core\Models;

use App\Models\Concerns\BelongsToTenant;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    use BelongsToTenant;

    protected $fillable = [
        'name',
        'guard_name',
        'tenant_id',
    ];
}
