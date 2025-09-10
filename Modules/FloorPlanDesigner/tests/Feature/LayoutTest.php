<?php

namespace {
    if (! function_exists('tenant')) {
        function tenant($key = null) {
            $tenant = \Modules\FloorPlanDesigner\Tests\Feature\TenantContext::$tenant ?? null;
            if (! $tenant) {
                return null;
            }
            return $key ? $tenant->{$key} : $tenant;
        }
    }
}

namespace Modules\FloorPlanDesigner\Tests\Feature {

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Modules\FloorPlanDesigner\Events\FloorLayoutUpdated;
use Modules\FloorPlanDesigner\Providers\FloorPlanDesignerServiceProvider;
use Tests\TestCase;
use App\Models\Tenant;

class TenantContext
{
    public static ?Tenant $tenant = null;
}

class LayoutTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->app->register(FloorPlanDesignerServiceProvider::class);
        $this->artisan('migrate', ['--path' => 'Modules/FloorPlanDesigner/database/migrations']);
        $this->withoutMiddleware();

        TenantContext::$tenant = new Tenant(['id' => 1]);
        app()->instance('tenant', TenantContext::$tenant);
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
}
