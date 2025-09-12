<?php

namespace Modules\EquipmentMonitoring\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Laravel\Pennant\Feature;
use Modules\EquipmentMonitoring\Events\MonitoringAlertRaised;
use Modules\EquipmentMonitoring\Models\MonitoringData;
use Modules\EquipmentMonitoring\Services\BufferHandler;
use Modules\EquipmentMonitoring\Services\ThresholdEvaluator;

class DataController extends Controller
{
    public function store(Request $request, ThresholdEvaluator $evaluator, BufferHandler $bufferHandler)
    {
        $data = $request->validate([
            'tenant_id' => 'required|uuid',
            'equipment_id' => 'required|string',
            'metric' => 'required|string',
            'value' => 'required|numeric',
            'offline' => 'sometimes|boolean',
        ]);

        $payload = [
            'tenant_id' => $data['tenant_id'],
            'equipment_id' => $data['equipment_id'],
            'metric' => $data['metric'],
            'value' => $data['value'],
            'timestamp' => now(),
        ];

        if (Feature::active('monitoring_iot_buffering') && ($data['offline'] ?? false)) {
            $bufferHandler->buffer($payload);
            return response()->json(['received' => true]);
        }

        $record = MonitoringData::create($payload);

        if ($evaluator->isBreached($record)) {
            event(new MonitoringAlertRaised($record->equipment_id, $record->metric, $record->value, $record->tenant_id));
        }

        return response()->json(['received' => true]);
    }
}
