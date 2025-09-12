<?php

namespace Modules\Jobs\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Modules\Jobs\Models\JobPosting;
use Tests\TestCase;

class ApplyTest extends TestCase
{
    use RefreshDatabase;

    public function test_application_submission(): void
    {
        Storage::fake('local');
        $posting = JobPosting::factory()->create();

        $response = $this->postJson('/api/v1/jobs/applications', [
            'job_id' => $posting->id,
            'cv' => UploadedFile::fake()->create('cv.pdf', 100),
        ]);

        $response->assertCreated()->assertJsonStructure(['app_id']);
        $this->assertDatabaseHas('jobs_applications', ['posting_id' => $posting->id]);
    }
}
