<?php

namespace Modules\Marketplace\Observers;

use Modules\Marketplace\Events\BidAwarded;
use Modules\Marketplace\Models\MarketplaceBid;

class MarketplaceBidObserver
{
    public function updated(MarketplaceBid $bid): void
    {
        if ($bid->isDirty('status') && $bid->status === 'awarded') {
            event(new BidAwarded($bid));
        }
    }
}
