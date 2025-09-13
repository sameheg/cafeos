<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TableController extends Controller
{
    /**
     * Show the table map.
     */
    public function index()
    {
        return view('livewire.pos.table-map');
    }

    /**
     * Store a newly created table or update existing ones.
     */
    public function store(Request $request)
    {
        // TODO: implement table storage logic
        return response()->json(['status' => 'ok']);
    }
}
