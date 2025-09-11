<?php

namespace Modules\Kiosk\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Laravel\Pennant\Feature;
use Modules\Kiosk\Events\KioskOrderCompleted;
use Modules\Kiosk\Models\Kiosk;
use Modules\Kiosk\Models\KioskOrder;
use Modules\Kiosk\Services\QueueLimiter;

class OrderController extends Controller
{
    public function store(Request $request, QueueLimiter $limiter)
    {
        $data = $request->validate([
            'kiosk_id' => ['required', 'exists:kiosks,id'],
            'items' => ['required', 'array'],
        ]);

        $kiosk = Kiosk::findOrFail($data['kiosk_id']);

        if (Feature::active('kiosk_max_queue') && $limiter->tooMany($kiosk)) {
            return response()->json(['message' => 'Queue Full'], 429);
        }

        $order = KioskOrder::create([
            'tenant_id' => $kiosk->tenant_id,
            'kiosk_id' => $kiosk->id,
            'total' => count($data['items']),
            'status' => 'queued',
        ]);

        event(new KioskOrderCompleted($order));

        return response()->json(['order_id' => $order->id]);
    }
}
