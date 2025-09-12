<?php

namespace Modules\EquipmentMaintenance\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\EquipmentMaintenance\Events\MonitoringAlertRaised;
use Modules\EquipmentMaintenance\Listeners\CreateTicketFromAlert;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event handler mappings for the application.
     *
     * @var array<string, array<int, string>>
     */
    protected $listen = [
        MonitoringAlertRaised::class => [
            CreateTicketFromAlert::class,
        ],
    ];

    /**
     * Indicates if events should be discovered.
     *
     * @var bool
     */
    protected static $shouldDiscoverEvents = true;

    /**
     * Configure the proper event listeners for email verification.
     */
    protected function configureEmailVerification(): void {}
}
