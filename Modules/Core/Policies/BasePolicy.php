<?php

namespace Modules\Core\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Modules\Core\Policies\Concerns\TenantScopedPermissions;

abstract class BasePolicy
{
    use HandlesAuthorization, TenantScopedPermissions;

    /**
     * Fully qualified model class name the policy applies to.
     */
    protected static string $model;

    public static function modelClass(): string
    {
        return static::$model;
    }

    protected function permission(string $action): string
    {
        $model = class_basename(static::$model);

        return Str::kebab($model).'.'.$action;
    }

    public function viewAny(User $user): bool
    {
        return $this->hasPermission($user, $this->permission('view-any'));
    }

    public function view(User $user, Model $model): bool
    {
        return $this->hasPermission($user, $this->permission('view'));
    }

    public function create(User $user): bool
    {
        return $this->hasPermission($user, $this->permission('create'));
    }

    public function update(User $user, Model $model): bool
    {
        return $this->hasPermission($user, $this->permission('update'));
    }

    public function delete(User $user, Model $model): bool
    {
        return $this->hasPermission($user, $this->permission('delete'));
    }
}
