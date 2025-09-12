<?php

namespace Modules\Jobs\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Jobs\Models\JobApplication;
use Modules\Jobs\Models\JobPosting;
use Tests\TestCase;

class PipelineFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_application_moves_through_pipeline(): void
    {
        $posting = JobPosting::factory()->create();
        $application = JobApplication::factory()->create(['posting_id' => $posting->id]);

        $application->screen();
        $this->assertEquals(JobApplication::STATUS_SCREENED, $application->fresh()->status);

        $application->hire();
        $this->assertEquals(JobApplication::STATUS_HIRED, $application->fresh()->status);
    }
}
