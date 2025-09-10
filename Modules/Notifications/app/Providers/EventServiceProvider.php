<?php

namespace Modules\Notifications\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\Billing\Events\UnpaidBillAlert;
use Modules\Inventory\Events\LowStockAlert;
use Modules\Membership\Events\SubscriptionExpiring;
use Modules\Notifications\Listeners\SendNotification;
use Modules\Pos\Events\TableOpened;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        LowStockAlert::class => [SendNotification::class],
        UnpaidBillAlert::class => [SendNotification::class],
        TableOpened::class => [SendNotification::class],
        SubscriptionExpiring::class => [SendNotification::class],
    ];
}
