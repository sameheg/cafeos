<?php

namespace Modules\Pos\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Modules\Pos\Models\PosOrder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Modules\Pos\Models\PosAudit;

class LoyaltyController
{
    public function redeem(Request $r, PosOrder $order): JsonResponse
    {
        $data = $r->validate(['points'=>'required|integer|min:1']);
        abort_unless($order->customer_id, 400, 'Order has no customer.');
        if (!Schema::hasTable('loyalty_points')) return response()->json(['ok'=>false,'error'=>'loyalty disabled'], 400);

        // Assume 1 point = 1 EGP by default (can be configured later).
        $value = (float)$data['points'];

        // Check available balance
        $earned = DB::table('loyalty_points')->where('tenant_id',$order->tenant_id)->where('customer_id',$order->customer_id)->sum('points');
        $redeemed = DB::table('loyalty_points')->where('tenant_id',$order->tenant_id)->where('customer_id',$order->customer_id)->sum('redeemed_points');
        $balance = (int)($earned - $redeemed);
        if ($data['points'] > $balance) return response()->json(['ok'=>false,'error'=>'insufficient points','balance'=>$balance], 400);

        // Apply redemption: reduce outstanding_total
        $out = (float)($order->outstanding_total ?? $order->total);
        $applied = min($value, $out);
        $order->outstanding_total = max(0, $out - $applied);
        $order->discount_total = ($order->discount_total ?? 0) + $applied;
        $order->save();

        // Record redemption
        DB::table('loyalty_points')->insert([
            'tenant_id'=>$order->tenant_id,
            'customer_id'=>$order->customer_id,
            'order_id'=>$order->id,
            'points'=>0,
            'redeemed_points'=>$data['points'],
            'created_at'=>now(),'updated_at'=>now(),
        ]);

        // Audit
        PosAudit::create(['tenant_id'=>$order->tenant_id,'user_id'=>auth()->id(),'action'=>'loyalty.redeem','entity_type'=>'order','entity_id'=>$order->id,'data'=>['points'=>$data['points'],'applied_value'=>$applied]]);

        return response()->json(['ok'=>true,'applied'=>$applied,'outstanding'=>$order->outstanding_total]);
    }
}
