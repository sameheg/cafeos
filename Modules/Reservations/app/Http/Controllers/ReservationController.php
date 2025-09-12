<?php

namespace Modules\Reservations\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laravel\Pennant\Feature;
use Modules\Reservations\Models\Reservation;
use Modules\Reservations\Models\ReservationStatus;
use Modules\Reservations\Services\CapacityChecker;
use Modules\Reservations\Services\OverbookException;

class ReservationController extends Controller
{
    public function store(Request $request, CapacityChecker $checker): JsonResponse
    {
        $data = $request->validate([
            'time' => ['required', 'date', 'after:now'],
            'table_id' => ['required', 'string'],
        ]);

        $tenantId = $request->input('tenant_id', app()->bound('tenant') ? app('tenant')->id : 't1');

        try {
            $checker->ensureCapacity($tenantId, new \DateTime($data['time']));
        } catch (OverbookException $e) {
            return response()->json(['message' => 'Overbooked'], 409);
        }

        $reservation = Reservation::create([
            'tenant_id' => $tenantId,
            'table_id' => $data['table_id'],
            'time' => $data['time'],
            'status' => ReservationStatus::Reserved,
        ]);

        if (Feature::active('reservations_deposits')) {
            // Deposit handling would occur here
        }

        return response()->json(['res_id' => $reservation->id]);
    }

    public function checkin(Reservation $reservation): JsonResponse
    {
        $reservation->update(['status' => ReservationStatus::CheckedIn]);

        return response()->json(['checked_in' => true]);
    }
}
