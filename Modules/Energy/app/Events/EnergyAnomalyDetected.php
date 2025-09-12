<?php

namespace Modules\Energy\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Modules\Energy\Models\EnergyLog;

class EnergyAnomalyDetected
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public EnergyLog $log)
    {
    }

    public function toArray(): array
    {
        return [
            'event' => 'energy.anomaly.detected',
            'data' => [
                'meter_id' => (string) $this->log->id,
                'kwh' => $this->log->kwh,
            ],
        ];
    }
}
