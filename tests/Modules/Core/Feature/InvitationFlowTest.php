<?php

namespace Tests\Modules\Core\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Core\Models\Tenant;
use Tests\TestCase;

class InvitationFlowTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function invitation_can_be_created_and_accepted(): void
    {
        $tenant = Tenant::create(['name' => 'A', 'slug' => 'a', 'status' => 'active']);
        app()->instance('currentTenant', $tenant);

        $token = $this->withHeader('X-Tenant', 'a')
            ->postJson('/v1/invitations', ['email' => 'test@example.com', 'role' => 'manager'])
            ->json('token');

        $this->withHeader('X-Tenant', 'a')->postJson('/v1/invitations/accept', ['token' => $token])->assertOk();
    }
}
