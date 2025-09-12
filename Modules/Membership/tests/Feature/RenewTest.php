<?php

namespace Modules\Membership\Tests\Feature;

use Illuminate\Support\Str;
use Modules\Membership\Models\Membership;
use Tests\TestCase;

class RenewTest extends TestCase
{
    public function test_membership_tier_can_be_updated_via_api(): void
    {
        $membership = Membership::create([
            'tenant_id' => (string) Str::uuid(),
            'customer_id' => (string) Str::uuid(),
            'tier' => 'silver',
            'expiry' => now()->addMonth(),
            'status' => 'active',
        ]);

        $response = $this->patchJson('/api/v1/membership/'.$membership->id, ['tier' => 'gold']);

        $response->assertOk()->assertJson(['updated' => true]);
        $this->assertEquals('gold', $membership->fresh()->tier);
    }
}
