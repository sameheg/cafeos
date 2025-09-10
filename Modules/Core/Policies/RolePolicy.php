<?php

namespace Modules\Core\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Core\Models\Role;

class RolePolicy
{
    use HandlesAuthorization;

    public static function modelClass(): string
    {
        return Role::class;
    }

    public function viewAny(User $user): bool
    {
        return $user->hasRole('Super Admin');
    }

    public function view(User $user, Role $role): bool
    {
        return $user->hasRole('Super Admin');
    }

    public function create(User $user): bool
    {
        return $user->hasRole('Super Admin');
    }

    public function update(User $user, Role $role): bool
    {
        return $user->hasRole('Super Admin');
    }

    public function delete(User $user, Role $role): bool
    {
        return $user->hasRole('Super Admin');
    }
}
