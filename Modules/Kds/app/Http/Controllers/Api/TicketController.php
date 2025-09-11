<?php

namespace Modules\Kds\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Kds\Events\TicketCompleted;
use Modules\Kds\Models\KdsTicket;

class TicketController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'order_id' => 'required|string',
            'station' => 'nullable|string',
        ]);

        $tenantId = $request->user()?->tenant_id ?? 'tenant-demo';

        $ticket = DB::transaction(function () use ($data, $tenantId) {
            return KdsTicket::create([
                'tenant_id' => $tenantId,
                'order_id' => $data['order_id'],
                'station' => $data['station'] ?? 'hot',
                'sla_time' => now()->addMinutes(10),
            ]);
        });

        return response()->json([
            'ticket_id' => $ticket->id,
        ]);
    }

    public function bump(string $id)
    {
        $ticket = KdsTicket::findOrFail($id);
        $ticket->bump();

        TicketCompleted::dispatch($ticket);

        return response()->json([
            'completed' => true,
        ]);
    }
}
