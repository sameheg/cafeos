<?php

namespace Modules\TableReservations\Tests\Feature;

use App\Http\Middleware\SetUserLocale;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\TableReservations\Models\WaitlistEntry;
use Modules\Notifications\Services\NotificationService;
use Mockery;
use Tests\TestCase;

class WaitlistFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_waitlist_update_sends_notifications(): void
    {
        $this->withoutMiddleware([SetUserLocale::class]);

        $user = User::factory()->create(['tenant_id' => 1]);
        $entry = WaitlistEntry::create([
            'customer_name' => 'Jane',
            'phone' => '9876543210',
            'party_size' => 2,
            'status' => 'waiting',
        ]);

        $this->app->alias('db', 'database');
        $mock = Mockery::mock(NotificationService::class);
        $mock->shouldReceive('send')->once();
        $this->app->instance(NotificationService::class, $mock);

        $response = $this->actingAs($user)->putJson('/api/v1/waitlist/' . $entry->id, ['status' => 'notified']);

        $response->assertOk();
        $this->assertDatabaseHas('waitlist_entries', ['id' => $entry->id, 'status' => 'notified']);
    }
}
