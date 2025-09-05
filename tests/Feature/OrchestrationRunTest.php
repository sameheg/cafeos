<?php

namespace Tests\Feature;

use App\Models\OrchestrationRun;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrchestrationRunTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_creates_an_orchestration_run(): void
    {
        $run = OrchestrationRun::create([
            'plan' => ['steps' => []],
        ]);

        $this->assertDatabaseHas('orchestration_runs', [
            'id' => $run->id,
            'status' => 'pending',
        ]);
    }
}

