<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Modules\Qr\Events\QrOrderPlaced;
use Modules\Qr\Models\QrCode;
use Tests\TestCase;

class PlaceOrderTest extends TestCase
{
    use RefreshDatabase;

    public function test_order_can_be_placed(): void
    {
        Event::fake([QrOrderPlaced::class]);

        $qr = QrCode::create([
            'tenant_id' => 'tenant',
            'table_id' => 'table1',
            'url' => 'https://example.com/qr/table1',
            'generated_at' => now(),
        ]);

        $response = $this->postJson('/v1/qr/orders', [
            'table_id' => 'table1',
            'items' => [
                ['price' => 5.00],
            ],
        ]);

        $response->assertStatus(200)->assertJsonStructure(['order_id']);
        $this->assertDatabaseHas('qr_orders', ['qr_id' => $qr->id]);
        Event::assertDispatched(QrOrderPlaced::class);
    }
}
