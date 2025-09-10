<?php

namespace Modules\EquipmentMonitoring\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\EquipmentMonitoring\Models\Device;

class DeviceController extends Controller
{
    public function index()
    {
        return Device::all();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'location' => 'nullable|string',
            'temperature_threshold' => 'required|numeric',
        ]);

        $device = Device::create($data);

        return response()->json($device, 201);
    }
}
