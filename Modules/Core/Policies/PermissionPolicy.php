<?php

namespace Modules\Core\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Core\Models\Permission;

class PermissionPolicy
{
    use HandlesAuthorization;

    public static function modelClass(): string
    {
        return Permission::class;
    }

    public function viewAny(User $user): bool
    {
        return $user->hasRole('Super Admin');
    }

    public function view(User $user, Permission $permission): bool
    {
        return $user->hasRole('Super Admin');
    }

    public function create(User $user): bool
    {
        return $user->hasRole('Super Admin');
    }

    public function update(User $user, Permission $permission): bool
    {
        return $user->hasRole('Super Admin');
    }

    public function delete(User $user, Permission $permission): bool
    {
        return $user->hasRole('Super Admin');
    }
}
