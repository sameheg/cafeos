<?php

namespace Modules\Pos\Tests\Feature;

use Modules\Pos\Models\PosOrder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateOrderTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_creates_order_via_api(): void
    {
        $response = $this->postJson('/api/v1/pos/orders', [
            'items' => [
                ['product_id' => 'p1', 'qty' => 1, 'price' => 5],
            ],
        ]);

        $response->assertStatus(200)->assertJsonStructure(['order_id', 'total']);
        $this->assertDatabaseCount('pos_orders', 1);
    }
}
