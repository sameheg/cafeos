<?php

namespace Modules\Jobs\Tests\Contract;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Jobs\Events\ApplicationReceived;
use Modules\Jobs\Models\JobApplication;
use Tests\TestCase;

class JobsEventSchemaTest extends TestCase
{
    use RefreshDatabase;

    public function test_application_received_schema(): void
    {
        $application = JobApplication::factory()->create();
        $event = new ApplicationReceived($application);

        $this->assertEquals(
            ['app_id' => $application->id, 'job_id' => $application->posting_id],
            $event->toArray()
        );
    }
}
