<?php

namespace Modules\EquipmentMonitoring\Services;

use Illuminate\Support\Facades\Cache;
use Modules\EquipmentMonitoring\Models\MonitoringData;
use Modules\EquipmentMonitoring\Models\MonitoringThreshold;

class ThresholdEvaluator
{
    public function isBreached(MonitoringData $data): bool
    {
        $threshold = Cache::remember(
            "monitoring_threshold:{$data->tenant_id}:{$data->metric}",
            60,
            fn () => MonitoringThreshold::where('tenant_id', $data->tenant_id)
                ->where('metric', $data->metric)
                ->first()
        );

        if (! $threshold) {
            return false;
        }

        return $data->value < $threshold->min || $data->value > $threshold->max;
    }
}
