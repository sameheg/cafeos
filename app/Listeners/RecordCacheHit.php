<?php

namespace App\Listeners;

use Illuminate\Cache\Events\CacheHit;
use Prometheus\CollectorRegistry;
use Prometheus\Storage\InMemory;
use Throwable;

class RecordCacheHit
{
    private CollectorRegistry $registry;

    public function __construct()
    {
        try {
            $this->registry = CollectorRegistry::getDefault();
        } catch (Throwable $e) {
            $this->registry = new CollectorRegistry(new InMemory);
        }
    }

    public function handle(CacheHit $event): void
    {
        $this->registry
            ->getOrRegisterCounter('app', 'cache_hits_total', 'Total cache hits')
            ->inc();
    }
}
