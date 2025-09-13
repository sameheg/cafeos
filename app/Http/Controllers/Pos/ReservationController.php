<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Services\ReservationService;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function __construct(private ReservationService $reservationService) {}

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
        $reservation = $this->reservationService->confirm($request->all());

        return response()->json([
            'status' => 'confirmed',
            'reservation' => $reservation,
        ]);
    }
}
