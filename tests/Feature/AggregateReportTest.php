<?php

namespace Tests\Feature;

use Illuminate\Support\Str;
use Modules\Franchise\Models\FranchiseTemplate;
use Tests\TestCase;

class AggregateReportTest extends TestCase
{
    public function test_report_returns_data(): void
    {
        FranchiseTemplate::create([
            'tenant_id' => (string) Str::uuid(),
            'type' => 'recipe',
            'data' => ['price' => 10],
        ]);

        $response = $this->getJson('/v1/franchise/reports/aggregate');

        $response->assertOk()->assertJsonStructure(['data']);
    }
}
