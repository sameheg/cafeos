<?php

namespace Tests\Feature;

use Modules\Pos\Events\OrderCreated;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Modules\Inventory\Listeners\UpdateInventory;
use Modules\Core\Contracts\OrderServiceInterface;
use Nwidart\Modules\Facades\Module as Modules;
use Tests\TestCase;

class ModuleToggleTest extends TestCase
{
    use RefreshDatabase;

    public function test_inventory_module_can_be_enabled_and_disabled(): void
    {
        Modules::disable('Inventory');
        $this->assertFalse(Modules::isEnabled('Inventory'));

        Modules::enable('Inventory');
        $this->assertTrue(Modules::isEnabled('Inventory'));
    }

    public function test_order_created_event_is_dispatched(): void
    {
        Modules::disable('Inventory');
        Event::fake();

        $order = app(OrderServiceInterface::class)->make();
        event(new OrderCreated($order));

        Event::assertDispatched(OrderCreated::class);
        Event::assertNotDispatched(UpdateInventory::class);
    }
}

