<?php

namespace Modules\EquipmentMonitoring\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\EquipmentMonitoring\Models\Device;

class DashboardController extends Controller
{
    public function index()
    {
        $devices = Device::with(['readings' => fn($q) => $q->latest()->limit(1)])->get();
        return view('equipmentmonitoring::dashboard', compact('devices'));
    }
}
