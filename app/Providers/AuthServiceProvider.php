<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\Tenant;
use Modules\Core\Models\Role;
use Modules\Core\Models\Permission;
use App\Policies\TenantPolicy;
use App\Policies\RolePolicy;
use App\Policies\PermissionPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Tenant::class => TenantPolicy::class,
        Role::class => RolePolicy::class,
        Permission::class => PermissionPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}
