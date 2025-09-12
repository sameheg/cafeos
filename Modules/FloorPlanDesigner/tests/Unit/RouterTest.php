<?php

namespace Modules\FloorPlanDesigner\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Modules\FloorPlanDesigner\Events\FloorplanUpdated;
use Modules\FloorPlanDesigner\Models\Floorplan;
use Tests\TestCase;

class RouterTest extends TestCase
{
    use RefreshDatabase;

    public function test_patch_dispatches_event(): void
    {
        Event::fake([FloorplanUpdated::class]);

        $plan = Floorplan::create([
            'tenant_id' => 't1',
            'json_data' => [],
            'version' => 1,
            'state' => 'draft',
        ]);

        $this->patchJson('/api/v1/floorplan/'.$plan->id, [
            'json_data' => ['tables' => [1,2]],
        ])->assertOk();

        Event::assertDispatched(FloorplanUpdated::class);
    }
}
