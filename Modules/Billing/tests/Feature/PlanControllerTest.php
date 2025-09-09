<?php

namespace Modules\Billing\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Modules\Billing\Http\Controllers\PlanController;
use Modules\Billing\Models\Plan;
use Tests\TestCase;

class PlanControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_returns_plans(): void
    {
        Artisan::call('migrate', ['--path' => 'Modules/Billing/database/migrations', '--realpath' => true]);
        Plan::factory()->create();

        $response = app(PlanController::class)->index();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertCount(1, $response->getData(true));
    }
}
