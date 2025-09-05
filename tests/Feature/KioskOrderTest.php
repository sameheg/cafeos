<?php

namespace Tests\Feature;

use Tests\TestCase;
use Mockery;
use App\Http\Controllers\SellPosController;

class KioskOrderTest extends TestCase
{
    public function test_kiosk_page_displays()
    {
        $response = $this->get('/kiosk');
        $response->assertStatus(200);
        $response->assertSee('Kiosk Order');
    }

    public function test_order_forwarded_to_sell_pos()
    {
        $mock = Mockery::mock(SellPosController::class);
        $mock->shouldReceive('store')->once()->andReturn(response('forwarded'));
        $this->app->instance(SellPosController::class, $mock);

        $response = $this->post('/kiosk/order', [
            'payment' => ['method' => 'cash'],
            'products' => []
        ]);

        $response->assertSee('forwarded');
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
