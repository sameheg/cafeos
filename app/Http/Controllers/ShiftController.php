<?php

namespace App\Http\Controllers;

use App\Models\Shift;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ShiftController extends Controller
{
    public function assign(Request $request): JsonResponse
    {
        $data = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'start_time' => ['required', 'date'],
            'end_time' => ['required', 'date', 'after:start_time'],
        ]);

        $shift = Shift::create([
            'user_id' => $data['user_id'],
            'start_time' => $data['start_time'],
            'end_time' => $data['end_time'],
            'assigned_by' => $request->user()?->id,
        ]);

        return response()->json($shift, 201);
    }

    public function swap(Request $request): JsonResponse
    {
        $data = $request->validate([
            'shift_id' => ['required', 'exists:shifts,id'],
            'new_user_id' => ['required', 'exists:users,id'],
        ]);

        $shift = Shift::findOrFail($data['shift_id']);
        $shift->update(['user_id' => $data['new_user_id']]);

        return response()->json($shift);
    }
}
