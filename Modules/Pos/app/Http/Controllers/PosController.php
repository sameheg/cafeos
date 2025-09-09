<?php

namespace Modules\Pos\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Pos\Models\MenuItem;

class PosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pos::index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pos::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'tenant_id' => ['required', 'integer'],
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
        ]);

        $item = MenuItem::create($data);

        return response()->json([
            'message' => __('pos.created'),
            'data' => $item,
        ], 201);
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('pos::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('pos::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $item = MenuItem::findOrFail($id);

        $data = $request->validate([
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'price' => ['sometimes', 'required', 'numeric', 'min:0'],
        ]);

        $item->update($data);

        return response()->json([
            'message' => __('pos.updated'),
            'data' => $item,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $item = MenuItem::findOrFail($id);
        $item->delete();

        return response()->json([
            'message' => __('pos.deleted'),
        ]);
    }
}
