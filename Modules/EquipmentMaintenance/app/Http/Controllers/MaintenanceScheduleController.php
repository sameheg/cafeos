<?php

namespace Modules\EquipmentMaintenance\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\EquipmentMaintenance\Models\MaintenanceSchedule;

class MaintenanceScheduleController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'tenant_id' => 'required|integer',
            'equipment_id' => 'required|integer',
            'scheduled_at' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $schedule = MaintenanceSchedule::create($data);

        return response()->json($schedule, 201);
    }
}
