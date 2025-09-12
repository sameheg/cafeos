<?php

namespace Modules\Dashboard\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\Dashboard\Events\DashboardAlertTriggered;

class TriggerAlert implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public string $kpi, public float $value)
    {
    }

    public function handle(): void
    {
        DashboardAlertTriggered::dispatch($this->kpi, $this->value);
    }
}
