<?php

namespace Modules\Pos\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
        abort(501);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort(501);
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        abort(501);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        abort(501);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        abort(501);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        abort(501);
    }
}
