<?php

namespace Modules\Crm\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Crm\Contracts\SurveyServiceInterface;
use Modules\Crm\Providers\CrmServiceProvider;
use Modules\Crm\Services\NpsAnalyticsService;
use Tests\TestCase;

class NpsAnalyticsServiceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->app->register(CrmServiceProvider::class);
    }

    public function test_calculates_nps_per_branch(): void
    {
        $service = $this->app->make(SurveyServiceInterface::class);
        $survey = $service->createSurvey(1, 1, 'How was your visit?');
        $service->submitResponse($survey->id, 1, 10);
        $service->submitResponse($survey->id, 1, 9);
        $service->submitResponse($survey->id, 1, 5);

        $analytics = new NpsAnalyticsService();
        $nps = $analytics->calculateForBranch(1);

        $this->assertEqualsWithDelta(33.33, $nps, 0.01);
    }
}
