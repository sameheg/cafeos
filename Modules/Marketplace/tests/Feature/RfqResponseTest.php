<?php

namespace Modules\Marketplace\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Marketplace\Models\MarketplaceStore;
use Tests\TestCase;

class RfqResponseTest extends TestCase
{
    use RefreshDatabase;

    public function test_supplier_can_submit_bid(): void
    {
        $store = MarketplaceStore::create([
            'tenant_id' => 't1',
            'supplier_id' => 'sup1',
            'name' => 'S1',
            'tier' => 'basic',
        ]);

        $response = $this->postJson('/api/v1/marketplace/bids', [
            'rfq_id' => 'r1',
            'price' => 10.5,
            'store_id' => $store->id,
            'tenant_id' => 't1',
        ]);

        $response->assertStatus(201)->assertJsonStructure(['bid_id']);
    }
}
