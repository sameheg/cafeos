<?php

namespace Modules\Loyalty\Contracts;

use Modules\Loyalty\Models\Coupon;

interface LoyaltyServiceInterface
{
    /**
     * Accrue loyalty points for a customer.
     */
    public function accruePoints(int|string $customerId, int $points, ?int $tenantId = null): void;

    /**
     * Redeem loyalty points for a customer.
     */
    public function redeemPoints(int|string $customerId, int $points): bool;

    /**
     * Get current loyalty points for a customer.
     */
    public function getPoints(int|string $customerId): int;

    /**
     * Issue a coupon/voucher to a customer.
     */
    public function issueCoupon(int|string $customerId, int $value): Coupon;

    /**
     * Redeem a coupon by code.
     */
    public function redeemCoupon(string $code): bool;
}
