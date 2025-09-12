<?php
namespace Modules\Reservations\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Reservations\App\Models\Reservation;
use Modules\Reservations\App\Http\Resources\ReservationResource;

/**
 * @group Reservations
 *
 * APIs for managing reservations
 */
class ReservationController extends Controller
{
    public function index()
    {
        return ReservationResource::collection(Reservation::paginate());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'tenant_id' => 'nullable|integer',
            'table_id' => 'required|integer',
            'status' => 'required|string|in:pending,confirmed,seated,cancelled',
            'start_at' => 'required|date',
            'end_at' => 'required|date|after:start_at',
        ]);

        $reservation = Reservation::create($data);
        return (new ReservationResource($reservation))->response()->setStatusCode(201);
    }

    public function show(Reservation $reservation)
    {
        return new ReservationResource($reservation);
    }

    public function update(Request $request, Reservation $reservation)
    {
        $data = $request->validate([
            'status' => 'sometimes|string|in:pending,confirmed,seated,cancelled',
            'start_at' => 'sometimes|date',
            'end_at' => 'sometimes|date|after:start_at',
        ]);

        $reservation->update($data);
        return new ReservationResource($reservation);
    }

    public function destroy(Reservation $reservation)
    {
        $reservation->delete();
        return response()->json(null, 204);
    }
}
