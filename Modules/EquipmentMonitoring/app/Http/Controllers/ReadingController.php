<?php

namespace Modules\EquipmentMonitoring\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\EquipmentMonitoring\Models\Device;

class ReadingController extends Controller
{
    public function store(Request $request, $device)
    {
        $data = $request->validate([
            'temperature' => 'nullable|numeric',
            'status' => 'required|string',
        ]);

        $device = Device::findOrFail($device);
        $reading = $device->readings()->create($data);

        $alert = null;
        if (isset($data['temperature']) && $data['temperature'] > $device->temperature_threshold) {
            $alert = $device->alerts()->create([
                'message' => 'High temperature: '.$data['temperature'],
            ]);
        }

        if (strtolower($data['status']) !== 'ok') {
            $alert = $device->alerts()->create([
                'message' => 'Status: '.$data['status'],
            ]);
        }

        return response()->json([
            'reading' => $reading,
            'alert' => $alert,
        ], 201);
    }
}
