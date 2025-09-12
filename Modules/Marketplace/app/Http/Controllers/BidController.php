<?php

namespace Modules\Marketplace\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Marketplace\Models\MarketplaceBid;

class BidController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'rfq_id' => 'required|string',
            'price' => 'required|numeric|min:0.01',
            'store_id' => 'required|string',
            'tenant_id' => 'sometimes|string',
        ]);

        $bid = MarketplaceBid::create([
            'tenant_id' => $data['tenant_id'] ?? 't1',
            'rfq_id' => $data['rfq_id'],
            'store_id' => $data['store_id'],
            'price' => $data['price'],
            'status' => 'open',
        ]);

        return response()->json(['bid_id' => $bid->id], 201);
    }
}
