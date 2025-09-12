<?php

namespace Modules\Marketplace\Tests\Contract;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Marketplace\Events\BidAwarded;
use Modules\Marketplace\Models\MarketplaceBid;
use Modules\Marketplace\Models\MarketplaceStore;
use Tests\TestCase;

class MarketplaceEventSchemaTest extends TestCase
{
    use RefreshDatabase;

    public function test_matches_bid_awarded_schema(): void
    {
        $store = MarketplaceStore::create([
            'tenant_id' => 't1',
            'supplier_id' => 'sup1',
            'name' => 'S1',
            'tier' => 'basic',
        ]);

        $bid = MarketplaceBid::create([
            'tenant_id' => 't1',
            'rfq_id' => 'r1',
            'store_id' => $store->id,
            'price' => 10,
            'status' => 'awarded',
        ]);

        $event = new BidAwarded($bid);

        $this->assertSame('marketplace.bid.awarded@v1', $event->payload['event']);
        $this->assertArrayHasKey('bid_id', $event->payload['data']);
    }
}
