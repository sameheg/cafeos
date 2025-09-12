<?php

namespace Modules\Jobs\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Modules\Jobs\Listeners\HireRequested;
use Modules\Jobs\Models\JobApplication;
use Modules\Jobs\Observers\JobApplicationObserver;

class JobsServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        JobApplication::observe(JobApplicationObserver::class);

        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');

        Event::listen('hr.hire.requested@v1', HireRequested::class);
    }
}
