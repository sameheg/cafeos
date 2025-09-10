<?php

namespace Modules\Dashboard\Tests\Unit;

use Illuminate\Support\Facades\Event;
use Modules\Dashboard\Events\DashboardUpdated;
use Modules\Dashboard\Services\DashboardBroadcaster;
use Tests\TestCase;

class DashboardBroadcasterTest extends TestCase
{
    public function test_broadcasts_dashboard_updates(): void
    {
        Event::fake();

        $broadcaster = new DashboardBroadcaster;
        $payload = ['sales' => 100];
        $broadcaster->broadcast($payload);

        Event::assertDispatched(DashboardUpdated::class, function ($event) use ($payload) {
            return $event->data === $payload;
        });
    }
}
