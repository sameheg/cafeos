<?php

namespace Tests\Feature;

use App\Models\KdsMetric;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class KdsMetricsApiTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Schema::create('kds_metrics', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ticket_id')->nullable();
            $table->integer('prep_time_seconds')->nullable();
            $table->integer('queue_time_seconds')->nullable();
            $table->timestamps();
        });
    }

    protected function tearDown(): void
    {
        Schema::dropIfExists('kds_metrics');
        parent::tearDown();
    }

    public function test_metrics_endpoint_returns_data(): void
    {
        KdsMetric::create([
            'ticket_id' => 1,
            'prep_time_seconds' => 5,
            'queue_time_seconds' => 2,
        ]);

        $response = $this->getJson('/api/kds/metrics');

        $response->assertStatus(200)
            ->assertJsonFragment([
                'ticket_id' => 1,
                'prep_time_seconds' => 5,
                'queue_time_seconds' => 2,
            ]);
    }
}
