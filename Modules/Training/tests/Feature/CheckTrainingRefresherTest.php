<?php

namespace Modules\Training\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Training\Models\TrainingCompletion;
use Modules\Training\Models\TrainingMaterial;
use Tests\TestCase;

class CheckTrainingRefresherTest extends TestCase
{
    use RefreshDatabase;

    public function test_command_logs_expired_training(): void
    {
        $material = TrainingMaterial::create([
            'tenant_id' => 1,
            'role_id' => 1,
            'title' => 'Safety',
            'content' => 'Keep safe',
        ]);

        TrainingCompletion::create([
            'tenant_id' => 1,
            'user_id' => 5,
            'training_material_id' => $material->id,
            'completed_at' => now()->subYear(),
            'expires_at' => now()->subDay(),
            'certified' => true,
        ]);

        $this->artisan('training:check-refresher')
            ->expectsOutput('Checked training refreshers: 1')
            ->assertExitCode(0);
    }
}
