<?php

namespace Modules\Pos\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Modules\Pos\Models\PosOrder;
use Modules\Pos\Models\PosPromotion;
use Modules\Pos\Models\PosPromotionRedemption;
use Modules\Pos\Models\PosPromotionRule;
use Modules\Pos\Models\PosAudit;

class PromotionController
{
    public function list(Request $r): JsonResponse {
        $tenant = $r->query('tenant_id');
        $q = PosPromotion::query()->where('active', true)->when($tenant, fn($x)=>$x->where('tenant_id',$tenant));
        return response()->json(['data'=>$q->latest()->paginate(20)]);
    }

    public function apply(Request $r, PosOrder $order): JsonResponse {
        $data = $r->validate(['code'=>'required']);
        $promo = PosPromotion::where('tenant_id', $order->tenant_id)
            ->where('code',$data['code'])->where('active',true)
            ->firstOrFail();

        $now = now();
        if (($promo->starts_at && $promo->starts_at > $now) || ($promo->ends_at && $promo->ends_at < $now)) {
            return response()->json(['ok'=>false,'error'=>'promotion not active'], 400);
        }

        $discount = $this->evaluate($promo, $order);

        if ($discount <= 0) {
            return response()->json(['ok'=>false,'error'=>'no discount applicable'], 400);
        }

        $red = PosPromotionRedemption::create([
            'tenant_id'=>$order->tenant_id,
            'promotion_id'=>$promo->id,
            'order_id'=>$order->id,
            'discount_amount'=>$discount,
            'code_used'=>$promo->code,
        ]);

        $order->discount_total = ($order->discount_total ?? 0) + $discount;
        $order->total = max(0, ($order->subtotal ?? 0) - ($order->discount_total ?? 0) + ($order->tax_amount ?? 0) + ($order->service_amount ?? 0));
        $order->outstanding_total = max(0, $order->total - ($order->paid_total ?? 0));
        $order->save();

        PosAudit::create(['tenant_id'=>$order->tenant_id,'user_id'=>auth()->id(),'action'=>'promotion.apply','entity_type'=>'order','entity_id'=>$order->id,'data'=>['code'=>$promo->code,'discount'=>$discount]]);

        return response()->json(['ok'=>true,'redemption'=>$red,'order'=>$order]);
    }

    protected function evaluate(PosPromotion $promo, PosOrder $order): float
    {
        $subtotal = (float)($order->subtotal ?? $order->items()->sum(\DB::raw('qty*price')));
        $discount = 0.0;

        foreach ($promo->rules as $rule) {
            $cond = $rule->conditions ?? [];
            // Simple condition checks
            if (!empty($cond['min_total']) && $subtotal < (float)$cond['min_total']) continue;
            if (!empty($cond['order_type']) && $order->order_type !== $cond['order_type']) continue;
            if (!empty($cond['after_hour']) && now()->format('H:i') < $cond['after_hour']) continue;
            if (!empty($cond['before_hour']) && now()->format('H:i') > $cond['before_hour']) continue;

            switch ($rule->type) {
                case 'percent_off':
                    $discount += round($subtotal * ((float)$rule->value / 100), 2);
                    break;
                case 'amount_off':
                    $discount += (float)$rule->value;
                    break;
                case 'bxgy':
                    // conditions: {"sku":"ESP-001","x":2,"y":1,"unit_price":50}
                    $sku = $cond['sku'] ?? null; $x = (int)($cond['x'] ?? 0); $y = (int)($cond['y'] ?? 0);
                    if ($sku && $x > 0 && $y > 0) {
                        $qty = $order->items()->where('sku',$sku)->sum('qty');
                        $free = intdiv($qty, $x + $y) * $y;
                        $unit = (float)($cond['unit_price'] ?? 0);
                        $discount += round($free * $unit, 2);
                    }
                    break;
                case 'happy_hour':
                    // conditions: {"after_hour":"17:00","before_hour":"19:00","percent":10}
                    $percent = (float)($cond['percent'] ?? 0);
                    $discount += round($subtotal * ($percent/100), 2);
                    break;
            }
        }
        return max(0.0, $discount);
    }
}
