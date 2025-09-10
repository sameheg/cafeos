<?php

namespace App\Listeners;

use Illuminate\Cache\Events\CacheMissed;
use Prometheus\CollectorRegistry;
use Prometheus\Storage\InMemory;
use Throwable;

class RecordCacheMiss
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

    public function handle(CacheMissed $event): void
    {
        $this->registry
            ->getOrRegisterCounter('app', 'cache_misses_total', 'Total cache misses')
            ->inc();
    }
}
