<?php

namespace Modules\HRJobs\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Modules\HRJobs\Models\Shift;
use Modules\HRJobs\Models\Employee;

class ShiftController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'employee_id' => 'required|string|exists:hr_employees,id',
            'time' => 'required|date',
        ]);

        $start = Carbon::parse($data['time']);
        $end = $start->copy()->addHours(8);

        $conflict = Shift::conflicts($data['employee_id'], $start, $end)->exists();
        if ($conflict) {
            return response()->json(['message' => 'conflict'], 409);
        }

        $shift = Shift::create([
            'tenant_id' => Employee::findOrFail($data['employee_id'])->tenant_id,
            'employee_id' => $data['employee_id'],
            'start' => $start,
            'end' => $end,
            'status' => Shift::STATUS_SCHEDULED,
        ]);

        return response()->json(['shift_id' => $shift->id]);
    }

    public function checkin(Shift $shift): JsonResponse
    {
        $shift->checkin();
        $shift->payroll();

        return response()->json(['status' => $shift->status]);
    }
}

