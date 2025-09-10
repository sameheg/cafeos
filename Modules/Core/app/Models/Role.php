<?php

namespace Modules\Core\Models;

use Spatie\Permission\Models\Role as SpatieRole;
use App\Models\Concerns\BelongsToTenant;

class Role extends SpatieRole
{
    use BelongsToTenant;

    protected $fillable = [
        'name',
        'guard_name',
        'tenant_id',
    ];
}
