<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Cache;
use Modules\Pos\Events\OrderCacheInvalidated;

class InvalidateOrderCache
{
    public function handle(OrderCacheInvalidated $event): void
    {
        Cache::tags('orders')->flush();
    }
}
