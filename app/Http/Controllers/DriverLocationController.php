<?php

namespace App\Http\Controllers;

use App\Models\DriverLocation;
use Illuminate\Http\Request;

class DriverLocationController extends Controller
{
    public function update(Request $request)
    {
        $data = $request->validate([
            'driver_id' => ['required', 'integer'],
            'latitude' => ['required', 'numeric'],
            'longitude' => ['required', 'numeric'],
        ]);

        DriverLocation::create([
            'driver_id' => $data['driver_id'],
            'latitude' => $data['latitude'],
            'longitude' => $data['longitude'],
            'recorded_at' => now(),
        ]);

        return response()->noContent();
    }
}
