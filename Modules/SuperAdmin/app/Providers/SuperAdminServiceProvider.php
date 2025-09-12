<?php

namespace Modules\SuperAdmin\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Laravel\Pennant\Feature;
use Modules\SuperAdmin\Listeners\BillingOverdueListener;
use Modules\SuperAdmin\Models\Flag;
use Modules\SuperAdmin\Observers\FlagObserver;

class SuperAdminServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');
        $this->loadRoutesFrom(__DIR__.'/../../routes/api.php');
        $this->loadTranslationsFrom(__DIR__.'/../../resources/lang', 'superadmin');

        Feature::define('superadmin_cohort_flags', fn () => true);

        Flag::observe(FlagObserver::class);

        Event::listen('billing.overdue@v1', BillingOverdueListener::class);
    }
}
