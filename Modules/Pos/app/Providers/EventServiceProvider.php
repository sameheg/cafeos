<?php

namespace Modules\Pos\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\FloorPlanDesigner\Events\FloorLayoutUpdated;
use Modules\Pos\Events\OrderCreated;
use Modules\Pos\Listeners\SyncFloorLayout;
use Modules\Pos\Listeners\AwardLoyaltyPoints;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event handler mappings for the application.
     *
     * @var array<string, array<int, string>>
     */
    protected $listen = [
        FloorLayoutUpdated::class => [
            SyncFloorLayout::class,
        ],
        OrderCreated::class => [
            AwardLoyaltyPoints::class,
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
