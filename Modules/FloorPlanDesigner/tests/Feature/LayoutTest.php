<?php

namespace Modules\FloorPlanDesigner\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Modules\FloorPlanDesigner\Events\FloorLayoutUpdated;
use Modules\FloorPlanDesigner\Providers\FloorPlanDesignerServiceProvider;
use Tests\TestCase;

class LayoutTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->app->register(FloorPlanDesignerServiceProvider::class);
        $this->artisan('migrate', ['--path' => 'Modules/FloorPlanDesigner/database/migrations']);
        $this->withoutMiddleware();
    }

    public function test_layout_can_be_saved()
    {
        Event::fake();
        $layout = [['type' => 'table', 'x' => 10, 'y' => 20]];
        $response = $this->post('floor-plan', ['layout' => json_encode($layout)]);
        $response->assertOk();
        $this->assertDatabaseHas('floor_layouts', ['tenant_id' => 1]);
        Event::assertDispatched(FloorLayoutUpdated::class);
    }
}

