<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Shift;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index()
    {
        $shifts = Shift::all();
        return view('staff.schedule', compact('shifts'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'employee_id' => 'required|exists:users,id',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
        ]);

        $shift = Shift::create($data);

        return response()->json($shift);
    }

    public function update(Request $request, Shift $shift)
    {
        $data = $request->validate([
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
        ]);

        $shift->update($data);

        return response()->json($shift);
    }
}
