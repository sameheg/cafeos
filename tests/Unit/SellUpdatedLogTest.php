<?php

namespace Tests\Unit;

use App\Events\SellUpdated;
use App\Transaction;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Activitylog\Models\Activity;
use Tests\TestCase;

class SellUpdatedLogTest extends TestCase
{
    use RefreshDatabase;

    public function test_log_entry_created_on_sell_update()
    {
        $user = User::create([
            'surname' => 'Mr',
            'first_name' => 'Test',
            'last_name' => 'User',
            'username' => 'testuser',
            'email' => 'test@example.com',
            'password' => bcrypt('secret'),
            'language' => 'en',
        ]);

        $before = new Transaction();
        $before->id = 1;
        $before->final_total = 100;

        $after = clone $before;
        $after->final_total = 150;

        $changes = [
            'final_total' => ['old' => 100, 'new' => 150],
        ];

        event(new SellUpdated($after, $user, $changes));

        $this->assertDatabaseHas('activity_log', [
            'description' => 'sell_updated',
            'causer_id' => $user->id,
            'subject_id' => $after->id,
            'subject_type' => Transaction::class,
        ]);

        $activity = Activity::latest()->first();
        $this->assertEquals(150, $activity->properties['attributes']['final_total']);
        $this->assertEquals(100, $activity->properties['old']['final_total']);
    }
}

