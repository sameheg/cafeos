<?php

namespace Modules\EquipmentMaintenance\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\EquipmentMaintenance\Models\MaintenanceLog;

class MaintenanceLogController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'equipment_id' => 'required|integer',
            'performed_at' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $log = MaintenanceLog::create($data);

        return response()->json($log, 201);
    }
}
