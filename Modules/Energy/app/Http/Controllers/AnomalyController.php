<?php

namespace Modules\Energy\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Energy\Models\EnergyLog;

class AnomalyController extends Controller
{
    public function index(Request $request)
    {
        $tenant = $request->header('X-Tenant-ID');

        $data = EnergyLog::where('tenant_id', $tenant)
            ->where('is_anomaly', true)
            ->get(['id as log_id', 'kwh', 'logged_at']);

        if ($data->isEmpty()) {
            return response()->json(['data' => []], 404);
        }

        return response()->json(['data' => $data]);
    }
}
