<?php

namespace Modules\HotelPms\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Modules\HotelPms\Adapters\PmsAdapterInterface;

class ReservationSyncController extends Controller
{
    public function __construct(private PmsAdapterInterface $adapter)
    {
    }

    public function index(): JsonResponse
    {
        $count = $this->adapter->syncReservations();

        return response()->json(['synced' => $count]);
    }
}
