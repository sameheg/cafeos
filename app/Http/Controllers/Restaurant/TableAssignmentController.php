<?php

namespace App\Http\Controllers\Restaurant;

use App\Restaurant\TableAssignment;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class TableAssignmentController extends Controller
{
    public function index()
    {
        return TableAssignment::whereNull('released_at')->get();
    }

    public function store(Request $request)
    {
        $data = $request->only(['res_table_id','waiter_id','assigned_at','released_at']);
        $assignment = TableAssignment::create($data);
        return response()->json($assignment, 201);
    }

    public function show($id)
    {
        return TableAssignment::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $assignment = TableAssignment::findOrFail($id);
        $assignment->update($request->only(['res_table_id','waiter_id','assigned_at','released_at']));
        return response()->json($assignment);
    }

    public function destroy($id)
    {
        TableAssignment::findOrFail($id)->delete();
        return response()->json(null, 204);
    }
}
