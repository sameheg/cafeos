<?php

namespace Tests\Feature;

use App\Events\KdsTicketCreated;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KdsBroadcastTest extends TestCase
{
    use RefreshDatabase;

    public function test_event_broadcasts_on_tenant_channel(): void
    {
        $event = new KdsTicketCreated(1, 5);

        $this->assertSame('private-tenant.1.kds.station.5', $event->broadcastOn()->name);
    }

    public function test_authorization_allows_same_tenant(): void
    {
        $this->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class);
        $user = User::factory()->create(['tenant_id' => 1]);

        $this->actingAs($user)
            ->post('/broadcasting/auth', [
                'channel_name' => 'private-tenant.1.kds.station.5',
                'socket_id' => '123.456',
            ], ['X-Requested-With' => 'XMLHttpRequest'])
            ->assertStatus(200);
    }

    public function test_authorization_denies_other_tenant(): void
    {
        $this->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class);
        $user = User::factory()->create(['tenant_id' => 2]);

        $this->actingAs($user)
            ->post('/broadcasting/auth', [
                'channel_name' => 'private-tenant.1.kds.station.5',
                'socket_id' => '123.456',
            ], ['X-Requested-With' => 'XMLHttpRequest'])
            ->assertStatus(403);
    }
}

