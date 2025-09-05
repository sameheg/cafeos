<?php

namespace Modules\POS\Services;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Restaurant\TableOrder;
use Modules\CRM\Services\CouponService;
use Modules\POS\Events\OrderCreated;
use Modules\POS\Events\OrderCompleted;

class OrderService
{
    protected CouponService $coupons;

    public function __construct(CouponService $coupons)
    {
        $this->coupons = $coupons;
    }

    public function processTableOrder(TableOrder $order): void
    {
        // Integrate with POS payment flow

        event(new OrderCreated($order));
    }

    public function completeOrder(TableOrder $order): void
    {
        $order->status = 'completed';
        $order->save();

        event(new OrderCompleted($order));
    }

    public function attachCoupon(int $orderId, string $code): bool
    {
        if (! $this->coupons->validate($code)) {
            return false;
        }

        DB::table('digital_coupons')
            ->where('code', $code)
            ->update([
                'order_id' => $orderId,
                'redeemed_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

        return true;
    }
}
