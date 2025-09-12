<?php

namespace Modules\Pos\Services;

use Illuminate\Support\Facades\DB;
use Modules\Pos\Models\PosOrder;
use Modules\Pos\Models\PosPromotion;

class PromotionService
{
    public static function applyCode(PosOrder $order, string $code): ?array
    {
        $promo = PosPromotion::where('tenant_id',$order->tenant_id)->where('code',$code)->where('active',true)->first();
        if (!$promo) return null;
        $discount = 0;
        foreach ($promo->rules as $rule) {
            switch($rule->type) {
                case 'percent_off':
                    $discount += ($order->subtotal * ($rule->value/100));
                    break;
                case 'amount_off':
                    $discount += $rule->value;
                    break;
                case 'bxgy':
                    // buy X get Y free, expects conditions {"buy":2,"get":1,"sku":"Coffee"}
                    $c = $rule->conditions ?? [];
                    if (!empty($c['sku']) && !empty($c['buy']) && !empty($c['get'])) {
                        $count = DB::table('pos_items')->where('order_id',$order->id)->where('name',$c['sku'])->sum('qty');
                        $eligible = intdiv($count, $c['buy']) * $c['get'];
                        if ($eligible>0) {
                            $price = DB::table('pos_items')->where('order_id',$order->id)->where('name',$c['sku'])->value('price');
                            $discount += $eligible * $price;
                        }
                    }
                    break;
                case 'happy_hour':
                    // conditions: {"hour_start":17,"hour_end":19,"percent":20}
                    $c = $rule->conditions ?? [];
                    $h = now()->hour;
                    if ($h >= ($c['hour_start']??0) && $h <= ($c['hour_end']??23)) {
                        $discount += ($order->subtotal * (($c['percent']??0)/100));
                    }
                    break;
            }
        }
        if ($discount>0) {
            $order->discount_total += $discount;
            $order->save();
            DB::table('pos_promotion_redemptions')->insert([
                'tenant_id'=>$order->tenant_id,'promotion_id'=>$promo->id,'order_id'=>$order->id,
                'discount_amount'=>$discount,'code_used'=>$promo->code,'created_at'=>now(),'updated_at'=>now()
            ]);
            return ['promotion'=>$promo->toArray(),'discount'=>$discount,'order'=>$order->toArray()];
        }
        return null;
    }
}
