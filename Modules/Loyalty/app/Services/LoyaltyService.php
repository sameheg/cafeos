<?php

namespace Modules\Loyalty\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Modules\Loyalty\Contracts\LoyaltyServiceInterface;
use Modules\Loyalty\Models\Coupon;
use Modules\Loyalty\Models\LoyaltyPoint;

class LoyaltyService implements LoyaltyServiceInterface
{
    public function accruePoints(int|string $customerId, int $points, ?int $tenantId = null): void
    {
        LoyaltyPoint::create([
            'customer_id' => $customerId,
            'tenant_id' => $tenantId,
            'points' => $points,
        ]);
    }

    public function redeemPoints(int|string $customerId, int $points): bool
    {
        return DB::transaction(function () use ($customerId, $points) {
            $current = $this->getPoints($customerId);
            if ($current < $points) {
                return false;
            }
            LoyaltyPoint::create([
                'customer_id' => $customerId,
                'points' => -$points,
            ]);
            return true;
        });
    }

    public function getPoints(int|string $customerId): int
    {
        return (int) LoyaltyPoint::where('customer_id', $customerId)->sum('points');
    }

    public function issueCoupon(int|string $customerId, int $value): Coupon
    {
        return Coupon::create([
            'customer_id' => $customerId,
            'code' => Str::uuid()->toString(),
            'value' => $value,
        ]);
    }

    public function redeemCoupon(string $code): bool
    {
        $coupon = Coupon::where('code', $code)->whereNull('redeemed_at')->first();
        if (! $coupon) {
            return false;
        }
        $coupon->update(['redeemed_at' => now()]);
        return true;
    }
}
