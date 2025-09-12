<?php

namespace Modules\Procurement\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Procurement\Models\Rfq;
use Symfony\Component\HttpFoundation\Response;

class RfqController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'items' => 'required|array',
        ]);

        $rfq = Rfq::create([
            'tenant_id' => (string) $request->user()?->tenant_id,
            'items' => $data['items'],
            'status' => 'open',
        ]);

        return response()->json(['rfq_id' => (string) $rfq->id], Response::HTTP_CREATED);
    }
}
