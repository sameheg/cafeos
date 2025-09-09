<?php

namespace Modules\HrJobs\Providers;

use Illuminate\Support\ServiceProvider;

class HrJobsServiceProvider extends ServiceProvider
{
    protected string $name = 'HrJobs';
    protected string $nameLower = 'hrjobs';

    public function boot(): void
    {
        $this->loadMigrationsFrom(module_path($this->name, 'database/migrations'));
        $this->loadViewsFrom(module_path($this->name, 'resources/views'), $this->nameLower);
    }

    public function register(): void
    {
        $this->app->register(RouteServiceProvider::class);
    }
}
