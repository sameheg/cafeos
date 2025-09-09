<?php

namespace Modules\Notifications\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\Inventory\Events\LowStockAlert;
use Modules\Billing\Events\UnpaidBillAlert;
use Modules\Pos\Events\TableOpened;
use Modules\Membership\Events\SubscriptionExpiring;
use Modules\Notifications\Listeners\SendNotification;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        LowStockAlert::class => [SendNotification::class],
        UnpaidBillAlert::class => [SendNotification::class],
        TableOpened::class => [SendNotification::class],
        SubscriptionExpiring::class => [SendNotification::class],
    ];
}
