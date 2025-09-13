<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    /**
     * List reservations.
     */
    public function index()
    {
        return response()->json([]);
    }

    /**
     * Store a reservation.
     */
    public function store(Request $request)
    {
        // TODO: implement reservation logic
        return response()->json(['status' => 'ok']);
    }
}
