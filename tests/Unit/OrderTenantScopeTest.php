<?php

namespace {
    if (! function_exists('tenant')) {
        function tenant($key = null) {
            $tenant = \Tests\Unit\TenantContext::$tenant ?? null;
            if (! $tenant) {
                return null;
            }
            return $key ? $tenant->{$key} : $tenant;
        }
    }
}

namespace Tests\Unit {

use App\Models\Tenant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Pos\Models\Order;
use Tests\TestCase;

class TenantContext
{
    public static ?Tenant $tenant = null;
}

class OrderTenantScopeTest extends TestCase
{
    use RefreshDatabase;

    public function test_tenant_id_is_set_on_creation(): void
    {
        $tenant = new Tenant(['id' => 1]);
        TenantContext::$tenant = $tenant;

        $order = Order::create([
            'total' => 100,
            'status' => 'pending',
        ]);

        $this->assertSame(1, $order->tenant_id);

        TenantContext::$tenant = null;
    }

    public function test_orders_are_isolated_by_tenant(): void
    {
        $tenant1 = new Tenant(['id' => 1]);
        TenantContext::$tenant = $tenant1;
        Order::create(['total' => 10, 'status' => 'pending']);

        $tenant2 = new Tenant(['id' => 2]);
        TenantContext::$tenant = $tenant2;
        Order::create(['total' => 20, 'status' => 'pending']);

        TenantContext::$tenant = $tenant1;
        $this->assertCount(1, Order::all());

        TenantContext::$tenant = $tenant2;
        $this->assertCount(1, Order::all());

        TenantContext::$tenant = null;
    }
}
}
