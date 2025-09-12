<?php

namespace Modules\EventManagement\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\EventManagement\Models\EventTicket;
use Modules\EventManagement\Observers\EventTicketObserver;
use Modules\EventManagement\Listeners\SeatAssignedListener;

class EventManagementServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadMigrationsFrom(module_path('EventManagement', 'database/migrations'));

        EventTicket::observe(EventTicketObserver::class);

        $this->app['events']->listen('reservations.seat.assigned@v1', [SeatAssignedListener::class, 'handle']);
    }

    public function register(): void
    {
        $this->app->register(RouteServiceProvider::class);
    }
}
