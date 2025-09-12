<?php

namespace Modules\Pos\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class OfflineSyncController
{
    public function token(Request $r): JsonResponse {
        $data = $r->validate(['tenant_id'=>'required','device_id'=>'required']);
        $token = \Modules\Pos\Models\PosSyncToken::firstOrCreate(['tenant_id'=>$data['tenant_id'],'device_id'=>$data['device_id']]);
        return response()->json(['token'=>$token->last_token]);
    }

    public function push(Request $r): JsonResponse {
        $payload = $r->validate(['mutations'=>'required|array']);
        $tenant = $r->input('tenant_id');
        $device = $r->input('device_id','unknown');
        foreach ($payload['mutations'] as $m) {
            $key = $m['key'] ?? null;
            if (!$key) continue;
            // idempotency: skip if applied
            $exists = DB::table('pos_offline_applied')->where('mutation_key',$key)->exists();
            if ($exists) continue;

            DB::transaction(function() use ($m, $tenant, $device){
                $type = $m['type'] ?? '';
                $data = $m['data'] ?? [];
                match ($type) {
                    'order.create' => $this->applyOrderCreate($data),
                    'order.item.add' => $this->applyOrderItemAdd($data),
                    'order.pay' => $this->applyOrderPay($data),
                    default => null,
                };
                DB::table('pos_offline_applied')->insert([
                    'tenant_id'=>$tenant, 'device_id'=>$device, 'mutation_key'=>$m['key'], 'created_at'=>now(),'updated_at'=>now()
                ]);
            }, 3);
        }
        return response()->json(['ok'=>true]);
    }

    protected function applyOrderCreate(array $d): void
    {
        $order = \Modules\Pos\Models\PosOrder::create([
            'tenant_id'=>$d['tenant_id'],'status'=>$d['status'] ?? 'new',
            'table_id'=>$d['table_id'] ?? null, 'customer_id'=>$d['customer_id'] ?? null,
            'subtotal'=>0,'tax_percent'=>$d['tax_percent'] ?? 0,'service_percent'=>$d['service_percent'] ?? 0,
            'discount_total'=>0,'total'=>0,'paid_total'=>0,'outstanding_total'=>0,'currency'=>$d['currency'] ?? 'EGP'
        ]);
    }

    protected function applyOrderItemAdd(array $d): void
    {
        $order = \Modules\Pos\Models\PosOrder::findOrFail($d['order_id']);
        $item = $order->items()->create([
            'tenant_id'=>$order->tenant_id,'name'=>$d['name'],'qty'=>$d['qty'],'price'=>$d['price']
        ]);
        \Modules\Pos\Services\InventoryService::decrementForItem($item);
        \Modules\Pos\Services\TotalsCalculator::recalc($order);
    }

    protected function applyOrderPay(array $d): void
    {
        $order = \Modules\Pos\Models\PosOrder::findOrFail($d['order_id']);
        $order->payments()->create([
            'tenant_id'=>$order->tenant_id,'method'=>$d['method'] ?? 'cash','amount'=>$d['amount'] ?? 0,'status'=>'captured'
        ]);
        \Modules\Pos\Services\TotalsCalculator::recalc($order);
        if ($order->outstanding_total <= 0) {
            $order->status = 'paid'; $order->save();
            \Modules\Pos\Services\BillingService::createInvoice($order);
            \Modules\Pos\Services\LoyaltyService::awardPoints($order);
        }
    }
}
