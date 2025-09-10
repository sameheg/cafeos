<?php

namespace Tests\Unit;

use App\Models\Tenant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Pos\Models\Order;
use Tests\TestCase;

class OrderTenantScopeTest extends TestCase
{
    use RefreshDatabase;

    protected function tearDown(): void
    {
        parent::tearDown();
        app()->forgetInstance('tenant');
    }

    public function test_tenant_id_is_set_on_creation(): void
    {
        app()->instance('tenant', new Tenant(['id' => 1]));

        $order = Order::create([
            'total' => 100,
            'status' => 'pending',
        ]);

        $this->assertSame(1, $order->tenant_id);
    }

    public function test_orders_are_isolated_by_tenant(): void
    {
        app()->instance('tenant', new Tenant(['id' => 1]));
        Order::create(['total' => 10, 'status' => 'pending']);

        app()->instance('tenant', new Tenant(['id' => 2]));
        Order::create(['total' => 20, 'status' => 'pending']);

        app()->instance('tenant', new Tenant(['id' => 1]));
        $this->assertCount(1, Order::all());

        app()->instance('tenant', new Tenant(['id' => 2]));
        $this->assertCount(1, Order::all());
    }
}
