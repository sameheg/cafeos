<?php

namespace App\Http\Controllers\Restaurant;

use App\Restaurant\WaiterShift;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class WaiterShiftController extends Controller
{
    public function index()
    {
        return WaiterShift::all();
    }

    public function store(Request $request)
    {
        $data = $request->only(['waiter_id','start_at','end_at']);
        $shift = WaiterShift::create($data);
        return response()->json($shift, 201);
    }

    public function show($id)
    {
        return WaiterShift::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $shift = WaiterShift::findOrFail($id);
        $shift->update($request->only(['waiter_id','start_at','end_at']));
        return response()->json($shift);
    }

    public function destroy($id)
    {
        WaiterShift::findOrFail($id)->delete();
        return response()->json(null, 204);
    }
}
