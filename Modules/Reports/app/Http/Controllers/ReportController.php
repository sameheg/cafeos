<?php

namespace Modules\Reports\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Reports\Models\Report;
use Modules\Reports\Models\ReportSchedule;

class ReportController extends Controller
{
    public function show(string $id)
    {
        $report = Report::findOrFail($id);
        $this->authorize('view', $report);

        return response()->json(['data' => $report]);
    }

    public function schedule(Request $request)
    {
        $validated = $request->validate([
            'report_id' => 'required|exists:reports,id',
            'frequency' => 'required|string',
        ]);

        ReportSchedule::create([
            'tenant_id' => $request->user()->tenant_id ?? '',
            'report_id' => $validated['report_id'],
            'frequency' => $validated['frequency'],
        ]);

        return response()->json(['scheduled' => true]);
    }
}
