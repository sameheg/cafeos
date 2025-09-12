<?php

namespace Modules\Reports\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Cache;

class DashboardKpiUpdatedListener implements ShouldQueue
{
    /**
     * Idempotent handling of dashboard KPI updates.
     */
    public function handle(array $event): void
    {
        $key = 'dashboard.kpi.updated@v1:'.$event['kpi_id'];
        $cache = Cache::store('redis');
        if ($cache->add($key, true, 3600)) {
            // refresh materialized views or aggregates
        }
    }

    public int $tries = 3;

    public function backoff(): array
    {
        return [1, 2, 4];
    }
}
