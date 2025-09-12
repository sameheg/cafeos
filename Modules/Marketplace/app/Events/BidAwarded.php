<?php

namespace Modules\Marketplace\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Modules\Marketplace\Models\MarketplaceBid;

class BidAwarded
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public array $payload;

    public function __construct(MarketplaceBid $bid)
    {
        $this->payload = [
            'event' => 'marketplace.bid.awarded@v1',
            'data' => [
                'bid_id' => $bid->id,
                'supplier' => optional($bid->store)->supplier_id,
            ],
        ];
    }
}
