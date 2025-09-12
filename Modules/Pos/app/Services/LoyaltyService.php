<?php

namespace Modules\Pos\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Modules\Pos\Models\PosOrder;

class LoyaltyService
{
    public static function awardPoints(PosOrder $order): void
    {
        if (!$order->customer_id) return;
        if (!Schema::hasTable('loyalty_points')) return;
        // rate: 1 point per 10 currency units (configurable later)
        $points = floor(($order->total ?? 0) / 10);
        if ($points <= 0) return;
        DB::table('loyalty_points')->insert([
            'tenant_id'=>$order->tenant_id,
            'customer_id'=>$order->customer_id,
            'order_id'=>$order->id,
            'points'=>$points,
            'created_at'=>now(),'updated_at'=>now(),
        ]);
    }
}
