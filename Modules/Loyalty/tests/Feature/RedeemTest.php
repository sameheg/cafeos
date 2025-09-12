<?php

namespace Modules\Loyalty\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Loyalty\Models\LoyaltyPoint;
use Tests\TestCase;

class RedeemTest extends TestCase
{
    use RefreshDatabase;

    public function test_redeem_points(): void
    {
        LoyaltyPoint::create([
            'tenant_id' => 'tenant-demo',
            'customer_id' => 'cust-1',
            'balance' => 100,
            'expiry' => now()->addDay(),
        ]);

        $resp = $this->postJson('/api/v1/loyalty/redeem', [
            'customer_id' => 'cust-1',
            'points' => 50,
        ]);
        $resp->assertOk()->assertJson(['success' => true]);
        $this->assertDatabaseHas('loyalty_points', ['customer_id' => 'cust-1', 'balance' => 50]);

        $resp2 = $this->postJson('/api/v1/loyalty/redeem', [
            'customer_id' => 'cust-1',
            'points' => 100,
        ]);
        $resp2->assertStatus(402);
    }
}
