<?php

namespace Modules\Energy\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Energy\Models\EnergyLog;

class LogController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kwh' => ['required', 'numeric', 'min:0.01'],
        ]);

        $log = EnergyLog::create([
            'tenant_id' => $request->header('X-Tenant-ID'),
            'kwh' => $validated['kwh'],
        ]);

        return response()->json(['log_id' => (string) $log->id]);
    }
}
