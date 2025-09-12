<?php
namespace Modules\Pos\App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Pos\App\Models\Order;
use Modules\Pos\App\Services\TotalsCalculator;
use Modules\Pos\App\Services\PosAudit;

class TableController extends Controller
{
    public function __construct(private PosAudit $audit) {}

    public function startOrder(Request $request)
    {
        $this->authorize('create', Order::class);
        $request->validate([ 'table_id' => 'required|integer' ]);

        // Reservation guard (optional if Reservations module exists)
        $tableId = (int)$request->input('table_id');
        $tenantId = tenant('id');
        if (config('pos.strict_reservation_guard', true) && class_exists('Modules\\Reservations\\App\\Services\\ReservationReader')) {
            $reader = app('Modules\\Reservations\\App\\Services\\ReservationReader');
            if ($reader->hasActiveOrImminentConflict($tenantId, $tableId, now())) {
                $this->audit->log('reservation.conflict', ['table_id'=>$tableId,'tenant_id'=>$tenantId]);
                return response()->json(['message'=>'Table is reserved / conflict detected','code'=>'RESERVATION_CONFLICT'], 409);
            }
        }

        $order = Order::create([
            'table_id' => $tableId,
            'tenant_id' => $tenantId,
            'status' => 'open',
            'subtotal' => 0,
            'discount_total' => 0,
            'tax_total' => 0,
            'total' => 0,
            'paid_total' => 0,
            'refunded_total' => 0,
        ]);

        $this->audit->log('order.open', ['order_id'=>$order->id]);

        return response()->json($order, 201);
    }

    public function addItem(Request $request, Order $order)
    {
        $this->authorize('update', $order);
        $data = $request->validate([
            'sku' => 'required|string',
            'name' => 'required|string',
            'qty' => 'required|numeric|min:0.01',
            'price' => 'required|numeric|min:0',
        ]);

        $item = $order->items()->create($data);

        // Reserve/consume inventory immediately if gateway present
        if (app()->bound('Modules\\Pos\\App\\Contracts\\InventoryGateway')) {
            $inv = app('Modules\\Pos\\App\\Contracts\\InventoryGateway');
            $inv->reserveItems([['sku'=>$item->sku,'qty'=>$item->qty]], ['order_id'=>$order->id]);
        }

        app(TotalsCalculator::class)->recalc($order->fresh('items'));

        $this->audit->log('order.add_item', ['order_id'=>$order->id,'sku'=>$item->sku,'qty'=>$item->qty]);

        return response()->json($item->fresh(), 201);
    }
}
