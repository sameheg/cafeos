<?php

namespace Modules\HR\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\HR\Entities\Attendance;

class AttendanceController extends Controller
{
    public function create()
    {
        return view('hr.attendance');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => ['required','integer'],
            'date' => ['required','date'],
            'status' => ['required','string'],
            'check_in' => ['nullable','date_format:H:i'],
            'check_out' => ['nullable','date_format:H:i'],
        ]);

        Attendance::create($data);

        return redirect()->back()->with('status', 'Attendance recorded');
    }
}
