<?php

namespace Modules\Kiosk\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Laravel\Pennant\Feature;
use Modules\Kiosk\Events\KioskOrderCompleted;
use Modules\Kiosk\Models\Kiosk;
use Tests\TestCase;

class PayTest extends TestCase
{
    use RefreshDatabase;

    public function test_order_can_be_created(): void
    {
        Feature::activate('kiosk_max_queue');
        Event::fake();

        $kiosk = Kiosk::create([
            'tenant_id' => 't1',
            'location' => 'Main',
            'status' => 'active',
            'max_queue' => 5,
        ]);

        $response = $this->postJson('/v1/kiosk/orders', [
            'kiosk_id' => $kiosk->id,
            'items' => [['id' => 1]],
        ]);

        $response->assertOk()->assertJsonStructure(['order_id']);
        Event::assertDispatched(KioskOrderCompleted::class);
        $this->assertDatabaseHas('kiosk_orders', ['kiosk_id' => $kiosk->id]);
    }
}
