<?php

namespace Modules\Dashboard\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Modules\Dashboard\Models\DashboardConfig;
use Modules\Dashboard\Services\KpiCalculator;
use Modules\Core\Models\EventLog;

class KpiController extends Controller
{
    public function kpis(Request $request, KpiCalculator $calculator)
    {
        $data = $request->validate([
            'time_window' => 'required|string',
        ]);

        return response()->json([
            'data' => $calculator->calculate($data['time_window']),
        ]);
    }

    public function customize(Request $request)
    {
        Gate::authorize('customize_dashboard');

        $payload = $request->validate([
            'widgets' => 'required|array',
        ]);

        $config = DashboardConfig::updateOrCreate(
            [
                'tenant_id' => app()->bound('tenant') ? app('tenant')->id : null,
                'user_id' => $request->user()->id,
            ],
            ['widgets' => $payload['widgets']]
        );

        EventLog::create([
            'event_name' => 'dashboard.customized',
            'data' => ['user_id' => $request->user()->id],
            'event_id' => (string) Str::ulid(),
        ]);

        return response()->json(['updated' => (bool) $config]);
    }
}
