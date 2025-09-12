<?php

namespace Modules\FoodSafety\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Modules\FoodSafety\Events\BreachDetected;
use Modules\FoodSafety\Models\FoodSafetyLog;
use Tests\TestCase;

class BreachAlertTest extends TestCase
{
    use RefreshDatabase;

    public function test_breach_dispatches_event(): void
    {
        Event::fake([BreachDetected::class]);

        FoodSafetyLog::create([
            'tenant_id' => 't1',
            'item_id' => 'item',
            'temp' => 10,
            'timestamp' => now(),
            'status' => 'monitored',
        ]);

        Event::assertDispatched(BreachDetected::class);
    }
}
