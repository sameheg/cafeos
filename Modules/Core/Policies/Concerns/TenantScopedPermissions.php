<?php

namespace Modules\Core\Policies\Concerns;

use App\Models\User;

trait TenantScopedPermissions
{
    protected function hasPermission(User $user, string $permission): bool
    {
        return $user->hasPermissionTo($permission, $user->tenant_id);
    }
}
