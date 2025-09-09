<?php

namespace Modules\SuperAdmin\Providers;

use Illuminate\Support\ServiceProvider;

class SuperAdminServiceProvider extends ServiceProvider
{
    public function register(): void
    {
    }

    public function boot(): void
    {
        $this->loadRoutesFrom(module_path('SuperAdmin', 'routes/api.php'));
    }
}
