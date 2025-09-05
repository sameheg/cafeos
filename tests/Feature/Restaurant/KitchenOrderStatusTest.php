<?php

namespace Tests\Feature\Restaurant;

use Tests\TestCase;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Restaurant\KitchenOrder;
use App\Events\KitchenOrderStatusUpdated;

class KitchenOrderStatusTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware();
    }

    public function test_kitchen_order_state_transition()
    {
        Event::fake();

        $order = KitchenOrder::create([
            'transaction_id' => 1,
            'item_id' => 1,
            'status' => 'pending',
        ]);

        $response = $this->post('/modules/kitchen-orders/' . $order->id . '/status', ['status' => 'completed']);
        $response->assertStatus(200);

        $order->refresh();
        $this->assertEquals('completed', $order->status);
        $this->assertNotNull($order->completed_at);

        Event::assertDispatched(KitchenOrderStatusUpdated::class, function ($e) use ($order) {
            return $e->orderId === $order->id && $e->status === 'completed';
        });
    }
}
