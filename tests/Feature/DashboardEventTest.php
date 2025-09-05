<?php

namespace Tests\Feature;

use App\Events\SalesUpdated;
use App\Events\StockUpdated;
use Illuminate\Support\Facades\Broadcast;
use Tests\TestCase;

class DashboardEventTest extends TestCase
{
    public function test_dashboard_metric_events_broadcast()
    {
        config([
            'broadcasting.default' => 'pusher',
            'broadcasting.connections.pusher.key' => 'key',
            'broadcasting.connections.pusher.secret' => 'secret',
            'broadcasting.connections.pusher.app_id' => 'app',
            'broadcasting.connections.pusher.options.cluster' => 'mt1',
        ]);

        Broadcast::fake();

        event(new SalesUpdated(150));
        event(new StockUpdated(30));

        Broadcast::assertBroadcasted(SalesUpdated::class, function ($event) {
            return $event->totalSales === 150;
        });

        Broadcast::assertBroadcasted(StockUpdated::class, function ($event) {
            return $event->productCount === 30;
        });
    }
}

