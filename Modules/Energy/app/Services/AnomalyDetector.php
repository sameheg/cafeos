<?php

namespace Modules\Energy\Services;

use Illuminate\Support\Facades\Event;
use Modules\Energy\Events\EnergyAnomalyDetected;
use Modules\Energy\Models\EnergyLog;

class AnomalyDetector
{
    public function __construct(protected BaselineCalculator $baseline)
    {
    }

    /**
     * Check the log for anomalies compared to the baseline.
     */
    public function check(EnergyLog $log): bool
    {
        $baseline = $this->baseline->forTenant($log->tenant_id);

        if ($baseline === null) {
            return false;
        }

        if ($log->kwh > $baseline * 1.2) {
            $log->is_anomaly = true;
            $log->save();

            Event::dispatch(new EnergyAnomalyDetected($log));

            return true;
        }

        return false;
    }
}
