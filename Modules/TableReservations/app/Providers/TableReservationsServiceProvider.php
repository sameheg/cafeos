<?php

namespace Modules\TableReservations\Providers;

use Illuminate\Support\ServiceProvider;

class TableReservationsServiceProvider extends ServiceProvider
{
    protected string $name = 'TableReservations';
    protected string $nameLower = 'tablereservations';

    public function boot(): void
    {
        $this->loadMigrationsFrom(module_path($this->name, 'database/migrations'));
        $this->loadRoutesFrom(module_path($this->name, 'routes/api.php'));
        $this->loadRoutesFrom(module_path($this->name, 'routes/web.php'));
    }

    public function register(): void
    {
        $this->app->register(RouteServiceProvider::class);
    }
}
