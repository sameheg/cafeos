<?php

namespace Modules\Loyalty\Listeners;

use Illuminate\Support\Facades\DB;
use Laravel\Pennant\Feature;
use Modules\Loyalty\Events\PointsEarned;
use Modules\Loyalty\Models\LoyaltyPoint;
use Modules\Loyalty\Models\LoyaltyRule;
use Modules\Pos\Events\OrderPaid;

class EarnPointsFromOrder
{
    public function handle(OrderPaid $event): void
    {
        $order = $event->order;
        $customerId = $order->customer_id ?? null;
        if (!$customerId) {
            return;
        }

        $rule = LoyaltyRule::where('tenant_id', $order->tenant_id)->first();
        $rate = $rule?->earn_rate ?? 1;

        if (Feature::active('loyalty_anti_stacking') && !$rule?->stackable && ($order->discount ?? 0) > 0) {
            return; // anti-stacking rule
        }

        $points = (int) floor($order->total * $rate);
        if ($points <= 0) {
            return;
        }

        DB::transaction(function () use ($order, $customerId, $points) {
            $wallet = LoyaltyPoint::firstOrNew([
                'tenant_id' => $order->tenant_id,
                'customer_id' => $customerId,
            ]);
            $wallet->balance = ($wallet->balance ?? 0) + $points;
            $wallet->expiry = $wallet->expiry ?? now()->addYear();
            $wallet->save();

            PointsEarned::dispatch($customerId, $points);
        });
    }
}
