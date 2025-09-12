<?php

namespace Modules\Pos\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Modules\Pos\Models\PosOrder;
use Modules\Pos\Models\PosPromotion;
use Modules\Pos\Models\PosPromotionRedemption;

class PromotionController
{
    public function list(Request $r): JsonResponse {
        $tenant = $r->query('tenant_id');
        $q = PosPromotion::query()->where('active', true)->when($tenant, fn($x)=>$x->where('tenant_id',$tenant));
        return response()->json(['data'=>$q->latest()->paginate(20)]);
    }

    public function apply(Request $r, PosOrder $order): JsonResponse {
        $data = $r->validate(['code'=>'required']);
        $promo = PosPromotion::where('tenant_id', $order->tenant_id)->where('code',$data['code'])->where('active',true)->firstOrFail();
        // NOTE: replace with real rules engine calc; for now flat 10% if found
        $discount = round(($order->subtotal ?? 0) * 0.10, 2);
        $red = PosPromotionRedemption::create([
            'tenant_id'=>$order->tenant_id,
            'promotion_id'=>$promo->id,
            'order_id'=>$order->id,
            'discount_amount'=>$discount,
            'code_used'=>$promo->code,
        ]);
        $order->discount_total = ($order->discount_total ?? 0) + $discount;
        $order->save();
        return response()->json(['redemption'=>$red,'order'=>$order]);
    }
}
