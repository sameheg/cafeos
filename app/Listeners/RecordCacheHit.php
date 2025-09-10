<?php

namespace App\Listeners;

use Illuminate\Cache\Events\CacheHit;
use Prometheus\CollectorRegistry;
use Prometheus\Storage\InMemory;

class RecordCacheHit
{
    private CollectorRegistry $registry;

    public function __construct()
    {
        $this->registry = class_exists('Redis')
            ? CollectorRegistry::getDefault()
            : new CollectorRegistry(new InMemory);
    }

    public function handle(CacheHit $event): void
    {
        $this->registry
            ->getOrRegisterCounter('app', 'cache_hits_total', 'Total cache hits')
            ->inc();
    }
}
