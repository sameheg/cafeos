<?php

namespace Modules\FoodSafety\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Modules\FoodSafety\Events\IngredientExpiring;
use Modules\FoodSafety\Models\IngredientInfo;
use Modules\FoodSafety\Services\FoodSafetyService;
use Modules\Inventory\Models\InventoryItem;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class FoodSafetyServiceTest extends TestCase
{
    use RefreshDatabase;

    protected FoodSafetyService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->app->register(\Modules\Inventory\Providers\InventoryServiceProvider::class);
        $this->app->register(\Modules\FoodSafety\Providers\FoodSafetyServiceProvider::class);
        $this->artisan('migrate', ['--path' => 'Modules/Inventory/database/migrations', '--realpath' => true]);
        $this->artisan('migrate', ['--path' => 'Modules/FoodSafety/database/migrations', '--realpath' => true]);
        $this->service = app(FoodSafetyService::class);
    }

    #[Test]
    public function it_dispatches_event_for_items_nearing_expiry(): void
    {
        Event::fake([IngredientExpiring::class]);

        $item = InventoryItem::create(['tenant_id' => 1, 'name' => 'Milk', 'quantity' => 1, 'alert_threshold' => 0]);
        IngredientInfo::create([
            'inventory_item_id' => $item->id,
            'expiry_date' => now()->addDay(),
            'allergens' => [],
        ]);

        $this->service->checkExpirations();

        Event::assertDispatched(IngredientExpiring::class);
    }
}
