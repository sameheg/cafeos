<?php

namespace Modules\Dashboard\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Modules\Dashboard\Services\KpiCalculator;

class PosOrderPaidListener implements ShouldQueue
{
    use InteractsWithQueue;

    public int $tries = 2;
    public array $backoff = [1, 2];

    public function __construct(public KpiCalculator $calculator)
    {
    }

    public function handle(object $event): void
    {
        // Update KPIs based on POS order paid events.
        $this->calculator->calculate('1m');
    }
}
