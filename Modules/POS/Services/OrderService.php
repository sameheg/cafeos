<?php

namespace Modules\POS\Services;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Modules\CRM\Services\CouponService;

class OrderService
{
    protected CouponService $coupons;

    public function __construct(CouponService $coupons)
    {
        $this->coupons = $coupons;
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
