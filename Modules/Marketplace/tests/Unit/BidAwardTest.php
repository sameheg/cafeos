<?php

namespace Modules\Marketplace\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Modules\Marketplace\Events\BidAwarded;
use Modules\Marketplace\Models\MarketplaceBid;
use Modules\Marketplace\Models\MarketplaceStore;
use Tests\TestCase;

class BidAwardTest extends TestCase
{
    use RefreshDatabase;

    public function test_awarding_dispatches_event(): void
    {
        Event::fake([BidAwarded::class]);

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
            'status' => 'open',
        ]);

        $bid->update(['status' => 'awarded']);

        Event::assertDispatched(BidAwarded::class, function ($event) use ($bid) {
            return $event->payload['data']['bid_id'] === $bid->id;
        });
    }
}
