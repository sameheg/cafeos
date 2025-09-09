<?php

namespace Modules\Jobs\Providers;

use Illuminate\Support\ServiceProvider;

class JobsServiceProvider extends ServiceProvider
{
    protected string $name = 'Jobs';
    protected string $nameLower = 'jobs';

    public function boot(): void
    {
        $this->loadMigrationsFrom(module_path($this->name, 'database/migrations'));
    }

    public function register(): void
    {
        $this->app->register(EventServiceProvider::class);
    }
}
