<?php

namespace Tests\Feature\Restaurant;

use App\Events\TableOrderPlaced;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Mockery;
use Modules\POS\Services\OrderService;
use Tests\TestCase;

class TableToKdsPosFlowTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware();
    }

    public function test_table_order_reaches_kds_and_pos()
    {
        $captured = null;
        Event::listen(TableOrderPlaced::class, function ($event) use (&$captured) {
            $captured = $event;
        });

        $orders = Mockery::mock(OrderService::class);
        $orders->shouldReceive('processTableOrder')->once();
        $this->app->instance(OrderService::class, $orders);

        $response = $this->postJson('/restaurant/tables/1/order', [
            'items' => [
                ['id' => 1, 'quantity' => 1],
            ],
        ]);
        $response->assertStatus(200);

        $this->assertNotNull($captured);

        $payload = json_encode(['id' => $captured->tableOrder->id, 'table_id' => $captured->tableOrder->table_id]);
        $output = shell_exec("echo '$payload' | node agents/agent-kds/src/listener.js");
        $this->assertStringContainsString('KDS received order', $output);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
