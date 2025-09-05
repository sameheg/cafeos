<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Broadcast;
use App\Events\OrderUpdated;
use App\Transaction;

class BroadcastTest extends TestCase
{
    public function test_order_updated_event_broadcasts_when_pusher_enabled()
    {
        config([
            'broadcasting.default' => 'pusher',
            'broadcasting.connections.pusher.key' => 'key',
            'broadcasting.connections.pusher.secret' => 'secret',
            'broadcasting.connections.pusher.app_id' => 'app',
            'broadcasting.connections.pusher.options.cluster' => 'mt1',
        ]);

        Broadcast::fake();

        $transaction = new Transaction();
        event(new OrderUpdated($transaction));

        Broadcast::assertBroadcasted(OrderUpdated::class);
    }
}
