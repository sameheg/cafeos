<?php

namespace Tests\Feature\Restaurant;

use App\Events\KdsTicketReady;
use App\Restaurant\TableOrder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class TicketReadyEventTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware();
    }

    public function test_event_dispatched_when_order_marked_ready(): void
    {
        Event::fake();

        $order = TableOrder::create([
            'table_id' => 1,
            'status' => 'pending',
            'placed_at' => now(),
        ]);

        $response = $this->postJson('/restaurant/orders/' . $order->id . '/ready');
        $response->assertStatus(200);

        $order->refresh();
        $this->assertEquals('ready', $order->status);

        Event::assertDispatched(KdsTicketReady::class, function ($e) use ($order) {
            return $e->order->id === $order->id;
        });
    }
}
