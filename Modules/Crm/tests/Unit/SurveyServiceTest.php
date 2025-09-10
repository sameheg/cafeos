<?php

namespace Modules\Crm\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Modules\Crm\Contracts\SurveyServiceInterface;
use Modules\Crm\Events\LowSurveyScore;
use Modules\Crm\Providers\CrmServiceProvider;
use Tests\TestCase;

class SurveyServiceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->app->register(CrmServiceProvider::class);
    }

    public function test_dispatches_event_on_low_score(): void
    {
        Event::fake();

        $service = $this->app->make(SurveyServiceInterface::class);
        $survey = $service->createSurvey(1, 1, 'How was your visit?');
        $service->submitResponse($survey->id, 1, 3);

        Event::assertDispatched(LowSurveyScore::class);
    }
}
