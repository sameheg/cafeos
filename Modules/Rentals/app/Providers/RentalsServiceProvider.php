<?php

namespace Modules\Rentals\Providers;

use Illuminate\Support\ServiceProvider;

class RentalsServiceProvider extends ServiceProvider
{
    protected string $name = 'Rentals';
    protected string $nameLower = 'rentals';

    public function boot(): void
    {
        $this->loadMigrationsFrom(module_path($this->name, 'database/migrations'));
    }

    public function register(): void
    {
        $this->app->register(RouteServiceProvider::class);
    }
}
