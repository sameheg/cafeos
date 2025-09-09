<?php

namespace Modules\EquipmentMaintenance\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\EquipmentMaintenance\Models\Equipment;

class EquipmentController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'tenant_id' => 'required|integer',
            'name' => 'required|string',
            'serial_number' => 'nullable|string',
            'description' => 'nullable|string',
            'purchased_at' => 'nullable|date',
        ]);

        $equipment = Equipment::create($data);

        return response()->json($equipment, 201);
    }
}
