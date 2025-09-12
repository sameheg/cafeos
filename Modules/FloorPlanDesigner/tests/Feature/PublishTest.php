<?php

namespace Modules\FloorPlanDesigner\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\FloorPlanDesigner\Models\Floorplan;
use Tests\TestCase;

class PublishTest extends TestCase
{
    use RefreshDatabase;

    public function test_publish_transition(): void
    {
        $plan = Floorplan::create([
            'tenant_id' => 't1',
            'json_data' => [],
            'version' => 1,
            'state' => 'draft',
        ]);

        $plan->publish();

        $this->assertEquals('published', $plan->state);
    }
}
