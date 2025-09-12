<?php

namespace Modules\EquipmentMaintenance\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\EquipmentMaintenance\Enums\TicketStatus;
use Modules\EquipmentMaintenance\Models\MaintenanceTicket;

class TicketController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'equipment_id' => 'required|string',
            'priority' => 'sometimes|integer|min:1|max:5',
            'tenant_id' => 'sometimes|uuid',
        ]);

        $ticket = MaintenanceTicket::create([
            'tenant_id' => $data['tenant_id'] ?? 't1',
            'equipment_id' => $data['equipment_id'],
            'priority' => $data['priority'] ?? 3,
            'status' => TicketStatus::Scheduled,
        ]);

        return response()->json(['ticket_id' => $ticket->id], 201);
    }

    public function complete(string $id): JsonResponse
    {
        $ticket = MaintenanceTicket::findOrFail($id);
        $ticket->finish();

        return response()->json(['completed' => true]);
    }
}
