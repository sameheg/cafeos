<?php
namespace Modules\Pos\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Pos\App\Models\Order;
use Modules\Reservations\App\Services\ReservationReader;

class TableController extends Controller
{
    public function startOrder(Request $request)
    {
        $request->validate([ 'table_id' => 'required|integer' ]);

        $tableId = (int)$request->input('table_id');
        $tenantId = tenant('id');

        if (app(ReservationReader::class)->hasActiveOrImminentConflict($tenantId, $tableId, now())) {
            return response()->json([
                'message' => 'Table is reserved / conflict detected',
                'code'    => 'RESERVATION_CONFLICT'
            ], 409);
        }

        $order = Order::create([
            'table_id' => $tableId,
            'tenant_id' => $tenantId,
            'status' => 'open',
            'subtotal' => 0,
            'discount_total' => 0,
            'tax_total' => 0,
            'total' => 0,
        ]);

        return response()->json($order, 201);
    }
}
