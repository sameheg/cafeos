<?php

namespace Modules\Energy\Observers;

use Modules\Energy\Models\EnergyLog;
use Modules\Energy\Services\AnomalyDetector;

class EnergyLogObserver
{
    public function __construct(protected AnomalyDetector $detector)
    {
    }

    public function created(EnergyLog $log): void
    {
        $this->detector->check($log);
    }
}
