<?php

namespace App\Providers;

use App\Events\AttendanceRecorded;
use App\Listeners\InvalidateInventoryCache;
use App\Listeners\InvalidateOrderCache;
use App\Listeners\RecordCacheHit;
use App\Listeners\RecordCacheMiss;
use App\Listeners\SendAttendanceToPayroll;
use Illuminate\Cache\Events\CacheHit;
use Illuminate\Cache\Events\CacheMissed;
use Modules\Inventory\Events\InventoryCacheInvalidated;
use Modules\Pos\Events\OrderCacheInvalidated;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        AttendanceRecorded::class => [
            SendAttendanceToPayroll::class,
        ],
        CacheHit::class => [
            RecordCacheHit::class,
        ],
        CacheMissed::class => [
            RecordCacheMiss::class,
        ],
        OrderCacheInvalidated::class => [
            InvalidateOrderCache::class,
        ],
        InventoryCacheInvalidated::class => [
            InvalidateInventoryCache::class,
        ],
    ];

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
