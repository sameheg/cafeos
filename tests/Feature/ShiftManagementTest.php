<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShiftManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_manager_can_assign_shift(): void
    {
        $manager = User::factory()->create(['tenant_id' => 1]);
        $employee = User::factory()->create(['tenant_id' => 1]);

        $this->withoutMiddleware(\App\Http\Middleware\SetUserLocale::class);
        $this->actingAs($manager);

        $response = $this->postJson('/manager/shifts/assign', [
            'user_id' => $employee->id,
            'start_time' => now()->addDay()->toDateTimeString(),
            'end_time' => now()->addDay()->addHours(8)->toDateTimeString(),
        ]);

        $response->assertCreated();

        $this->assertDatabaseHas('shifts', [
            'user_id' => $employee->id,
        ]);
    }
}
