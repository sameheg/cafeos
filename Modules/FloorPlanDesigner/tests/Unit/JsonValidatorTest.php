<?php

namespace Modules\FloorPlanDesigner\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\FloorPlanDesigner\Models\Floorplan;
use Tests\TestCase;

class JsonValidatorTest extends TestCase
{
    use RefreshDatabase;

    public function test_invalid_json_returns_400(): void
    {
        $plan = Floorplan::create([
            'tenant_id' => 't1',
            'json_data' => [],
            'version' => 1,
            'state' => 'draft',
        ]);

        $response = $this->patchJson('/api/v1/floorplan/'.$plan->id, [
            'json_data' => 'invalid',
        ]);

        $response->assertStatus(400);
    }
}
