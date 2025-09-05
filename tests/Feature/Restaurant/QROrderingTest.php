<?php

namespace Tests\Feature\Restaurant;

use Tests\TestCase;

class QROrderingTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware();
    }

    public function test_qr_ordering_workflow()
    {
        $tableId = 1;

        $qr = $this->get("/restaurant/tables/{$tableId}/qr");
        $qr->assertStatus(200);
        $qr->assertHeader('Content-Type', 'image/png');

        $menu = $this->get("/restaurant/tables/{$tableId}/menu");
        $menu->assertStatus(200);
        $menu->assertJsonStructure(['table_id', 'items']);

        $order = $this->postJson("/restaurant/tables/{$tableId}/order", [
            'items' => [
                ['id' => 1, 'quantity' => 2],
            ],
        ]);
        $order->assertStatus(200);
        $order->assertJson([
            'success' => true,
            'table_id' => $tableId,
        ]);
    }
}
