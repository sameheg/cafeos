<?php

namespace App\Listeners;

use Illuminate\Cache\Events\CacheMissed;
use Prometheus\CollectorRegistry;
use Prometheus\Storage\InMemory;

class RecordCacheMiss
{
    private CollectorRegistry $registry;

    public function __construct()
    {
        $this->registry = class_exists('Redis')
            ? CollectorRegistry::getDefault()
            : new CollectorRegistry(new InMemory);
    }

    public function handle(CacheMissed $event): void
    {
        $this->registry
            ->getOrRegisterCounter('app', 'cache_misses_total', 'Total cache misses')
            ->inc();
    }
}
