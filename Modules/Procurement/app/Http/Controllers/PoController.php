<?php

namespace Modules\Procurement\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Procurement\Models\Bid;
use Modules\Procurement\Models\Po;
use Modules\Procurement\Models\PoStatus;
use Modules\Procurement\Models\Rfq;
use Symfony\Component\HttpFoundation\Response;

class PoController extends Controller
{
    public function store(Request $request, Rfq $rfq)
    {
        $data = $request->validate([
            'bid_id' => 'required|exists:procurement_bids,id',
        ]);

        /** @var Bid $bid */
        $bid = Bid::find($data['bid_id']);

        if ($bid->rfq_id !== $rfq->id || $rfq->status !== 'open') {
            return response()->json(['message' => 'conflict'], Response::HTTP_CONFLICT);
        }

        $po = Po::create([
            'tenant_id' => $rfq->tenant_id,
            'bid_id' => $bid->id,
            'amount' => $bid->price,
            'status' => PoStatus::Draft,
        ]);

        return response()->json(['po_id' => (string) $po->id]);
    }
}
