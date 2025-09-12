<?php

namespace Modules\Rentals\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use Modules\Rentals\Models\Contract;
use Modules\Rentals\Models\Listing;

class ContractController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'space_id' => 'required|string',
        ]);

        $listing = Listing::findOrFail($data['space_id']);

        if ($listing->status === 'rented') {
            return response()->json(['message' => 'Occupied'], 409);
        }

        $contract = Contract::create([
            'id' => (string) Str::ulid(),
            'tenant_id' => $listing->tenant_id,
            'listing_id' => $listing->id,
            'renter_id' => (string) ($request->user()->id ?? 'renter'),
            'end_date' => now()->addMonth(),
            'status' => 'active',
        ]);

        $listing->update(['status' => 'rented']);

        return response()->json(['contract_id' => $contract->id]);
    }
}
