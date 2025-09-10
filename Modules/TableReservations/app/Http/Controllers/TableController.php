<?php

namespace Modules\TableReservations\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\TableReservations\Models\Table;

class TableController extends Controller
{
    public function index()
    {
        return Table::all();
    }

    public function store(Request $request)
    {
        return Table::create($request->validate([
            'name' => 'required',
            'seats' => 'required|integer',
            'status' => 'required',
        ]));
    }

    public function update(Request $request, Table $table)
    {
        $table->update($request->only(['name', 'seats', 'status']));

        return $table;
    }

    public function destroy(Table $table)
    {
        $table->delete();

        return response()->noContent();
    }
}
