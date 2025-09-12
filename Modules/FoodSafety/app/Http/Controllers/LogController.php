<?php

namespace Modules\FoodSafety\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\FoodSafety\Models\FoodSafetyLog;

class LogController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'temp' => 'required|numeric|between:-20,100',
            'item_id' => 'required|string',
        ]);

        $log = FoodSafetyLog::create([
            'tenant_id' => $request->user()->tenant_id ?? 't1',
            'item_id' => $data['item_id'],
            'temp' => $data['temp'],
            'timestamp' => now(),
            'status' => 'monitored',
        ]);

        return response()->json(['log_id' => $log->id]);
    }

    public function incidents()
    {
        $data = FoodSafetyLog::where('status', 'alerted')->get();
        if ($data->isEmpty()) {
            return response()->json(['data' => []]);
        }
        return response()->json(['data' => $data]);
    }
}
