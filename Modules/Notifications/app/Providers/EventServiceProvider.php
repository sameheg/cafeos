<?php

namespace Modules\Notifications\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\Core\Events\JsonDomainEvent;
use Modules\Notifications\Listeners\CampaignSentListener;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        JsonDomainEvent::class => [CampaignSentListener::class],
    ];
}
