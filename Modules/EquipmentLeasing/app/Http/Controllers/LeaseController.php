<?php

namespace Modules\EquipmentLeasing\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Modules\EquipmentLeasing\Models\EquipmentLease;
use Modules\EquipmentLeasing\Models\EquipmentListing;

class LeaseController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'equipment_id' => ['required', 'string'],
        ]);

        $listing = EquipmentListing::find($data['equipment_id']);

        if (! $listing || ! $listing->available) {
            return response()->json(['message' => 'Unavailable'], 409);
        }

        $lease = EquipmentLease::create([
            'id' => (string) Str::ulid(),
            'tenant_id' => $request->user()->tenant_id ?? 'tenant',
            'equipment_id' => $listing->id,
            'end_date' => now()->addMonth(),
            'status' => 'active',
        ]);

        return response()->json(['lease_id' => $lease->id]);
    }

    public function uptime(EquipmentLease $lease): JsonResponse
    {
        $uptime = Cache::remember("lease:{$lease->id}:uptime", 60, fn () => 95.0);

        return response()->json(['uptime' => $uptime]);
    }
}

