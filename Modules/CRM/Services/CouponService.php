<?php

namespace Modules\CRM\Services;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CouponService
{
    public function generate(float $amount, ?Carbon $expiresAt = null): array
    {
        $code = strtoupper(Str::random(10));

        $id = DB::table('digital_coupons')->insertGetId([
            'code' => $code,
            'discount_amount' => $amount,
            'expires_at' => $expiresAt,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return (array) DB::table('digital_coupons')->find($id);
    }

    public function validate(string $code): bool
    {
        $coupon = DB::table('digital_coupons')->where('code', $code)->first();

        if (!$coupon || !$coupon->is_active) {
            return false;
        }

        if ($coupon->redeemed_at !== null) {
            return false;
        }

        if ($coupon->expires_at && Carbon::parse($coupon->expires_at)->isPast()) {
            return false;
        }

        return true;
    }
}
