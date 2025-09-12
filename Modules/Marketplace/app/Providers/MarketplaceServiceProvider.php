<?php

namespace Modules\Marketplace\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Marketplace\Models\MarketplaceBid;
use Modules\Marketplace\Observers\MarketplaceBidObserver;

class MarketplaceServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        MarketplaceBid::observe(MarketplaceBidObserver::class);
    }
}
