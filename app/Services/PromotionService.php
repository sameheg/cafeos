<?php

namespace App\Services;

use App\Models\PurchaseHistory;
use App\Models\User;

class PromotionService
{
    /**
     * Determine promotions for the given customer.
     *
     * @return list<string>
     */
    public function getPromotionsForCustomer(User $user): array
    {
        $count = PurchaseHistory::where('user_id', $user->id)->count();

        $promotions = [];

        if ($count >= 5) {
            $promotions[] = '10% off next purchase';
        }

        if ($count < 5) {
            $promotions[] = 'Buy one get one free';
        }

        return $promotions;
    }
}
