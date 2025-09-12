<?php

namespace Modules\EquipmentMonitoring\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\EquipmentMonitoring\Models\MonitoringData;
use Modules\EquipmentMonitoring\Services\ThresholdEvaluator;

class AlertController extends Controller
{
    public function index(Request $request, ThresholdEvaluator $evaluator)
    {
        $tenant = $request->validate([
            'tenant_id' => 'required|uuid',
        ]);

        $alerts = MonitoringData::where('tenant_id', $tenant['tenant_id'])
            ->get()
            ->filter(fn ($row) => $evaluator->isBreached($row))
            ->map(fn ($row) => [
                'equipment_id' => $row->equipment_id,
                'metric' => $row->metric,
                'value' => $row->value,
                'timestamp' => $row->timestamp,
            ])->values();

        if ($alerts->isEmpty()) {
            abort(404, 'Not Found');
        }

        return ['alerts' => $alerts];
    }
}
