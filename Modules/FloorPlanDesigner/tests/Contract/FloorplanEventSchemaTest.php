<?php

namespace Modules\FloorPlanDesigner\Tests\Contract;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Modules\FloorPlanDesigner\Events\FloorplanUpdated;
use Modules\FloorPlanDesigner\Models\Floorplan;
use Tests\TestCase;

class FloorplanEventSchemaTest extends TestCase
{
    use RefreshDatabase;

    public function test_event_schema_contains_required_fields(): void
    {
        Event::fake([FloorplanUpdated::class]);

        $plan = Floorplan::create([
            'tenant_id' => 't1',
            'json_data' => [],
            'version' => 1,
            'state' => 'draft',
        ]);

        $plan->update(['json_data' => ['tables' => [1]]]);

        Event::assertDispatched(FloorplanUpdated::class, function ($event) {
            $payload = $event->toArray();
            return isset($payload['plan_id']) && isset($payload['changes']);
        });
    }
}
