<?php

namespace Tests\Feature;

use App\Models\Shift;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StaffScheduleTest extends TestCase
{
    use RefreshDatabase;

    public function test_staff_can_view_schedule_page()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/staff/schedule');
        $response->assertStatus(200);
    }

    public function test_staff_can_create_and_update_shift()
    {
        $user = User::factory()->create();
        $start = now()->addHour();
        $end = $start->copy()->addHours(8);

        $create = $this->actingAs($user)->post('/staff/schedule', [
            'employee_id' => $user->id,
            'start_time' => $start->toDateTimeString(),
            'end_time' => $end->toDateTimeString(),
        ]);
        $create->assertStatus(200);

        $shift = Shift::first();
        $this->assertNotNull($shift);
        $this->assertDatabaseHas('shifts', [
            'employee_id' => $user->id,
            'start_time' => $start->toDateTimeString(),
            'end_time' => $end->toDateTimeString(),
        ]);

        $newEnd = $end->copy()->addHour();
        $update = $this->actingAs($user)->put("/staff/schedule/{$shift->id}", [
            'start_time' => $start->toDateTimeString(),
            'end_time' => $newEnd->toDateTimeString(),
        ]);
        $update->assertStatus(200);

        $this->assertDatabaseHas('shifts', [
            'id' => $shift->id,
            'end_time' => $newEnd->toDateTimeString(),
        ]);
    }
}
