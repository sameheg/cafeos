<?php

namespace Modules\Pos\Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Middleware\InitializeTenancyByDomain;
use App\Http\Middleware\SetUserLocale;
use Modules\Pos\Models\Order;
use Modules\Pos\Events\TableOpened;

class WaiterControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware([
            InitializeTenancyByDomain::class,
            SetUserLocale::class,
        ]);
        $user = User::factory()->create(['tenant_id' => 1]);
        $this->actingAs($user);
    }

    public function test_move_updates_table_and_emits_event(): void
    {
        Event::fake();

        $order = Order::create([
            'tenant_id' => 1,
            'total' => 100,
            'status' => 'pending',
            'table_id' => 1,
        ]);

        $response = $this->postJson("/waiter/orders/{$order->id}/move", [
            'table_id' => 2,
        ]);

        $response->assertOk();
        $response->assertJson(['message' => __('pos::moved')]);
        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'table_id' => 2,
        ]);
        Event::assertDispatched(TableOpened::class);
    }

    public function test_split_persists_parts(): void
    {
        $order = Order::create([
            'tenant_id' => 1,
            'total' => 100,
            'status' => 'pending',
            'table_id' => 1,
        ]);

        $response = $this->postJson("/waiter/orders/{$order->id}/split", [
            'parts' => 2,
        ]);

        $response->assertOk();
        $response->assertJson([
            'message' => __('pos::split'),
            'parts' => [50.0, 50.0],
        ]);

        $order->refresh();
        $this->assertEquals([50.0, 50.0], $order->split);
    }
}
