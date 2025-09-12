<?php

namespace Modules\Rentals\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Routing\Controller;
use Modules\Rentals\Models\Listing;

class OccupancyController extends Controller
{
    public function show(): JsonResponse
    {
        $rate = Cache::remember('rentals.occupancy', 60, function () {
            $total = Listing::count();
            if ($total === 0) {
                abort(404);
            }
            $rented = Listing::where('status', 'rented')->count();
            return $total > 0 ? $rented / $total : 0;
        });

        return response()->json(['rate' => $rate]);
    }
}
