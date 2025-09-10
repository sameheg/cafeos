<?php

namespace Modules\TableReservations\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Notifications\Services\NotificationService;
use Modules\TableReservations\Models\Reservation;

class ReservationController extends Controller
{
    public function index()
    {
        return Reservation::all();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'table_id' => 'required|integer',
            'customer_name' => 'required',
            'phone' => 'required',
            'reservation_time' => 'required|date',
        ]);
        $data['status'] = 'pending';

        return Reservation::create($data);
    }

    public function update(Request $request, Reservation $reservation)
    {
        $reservation->update($request->only(['reservation_time', 'status']));

        return $reservation;
    }

    public function confirm(Reservation $reservation, NotificationService $notifications)
    {
        $reservation->update(['status' => 'confirmed']);
        $notifications->send('Reservation confirmed for '.$reservation->customer_name, ['sms', 'push']);

        return response()->json(['status' => 'confirmed']);
    }
}
