<?php

namespace App\Services;

use App\Models\LoyaltyPoint;
use Illuminate\Support\Facades\DB;
use Exception;

class LoyaltyService
{
    public function earnPoints(int $userId, float $amount): LoyaltyPoint
    {
        $points = (int) $amount;
        return DB::transaction(function () use ($userId, $points) {
            $record = LoyaltyPoint::firstOrCreate(['user_id' => $userId]);
            $record->increment('points', $points);
            return $record;
        });
    }

    public function redeemPoints(int $userId, int $points): LoyaltyPoint
    {
        return DB::transaction(function () use ($userId, $points) {
            $record = LoyaltyPoint::firstOrCreate(['user_id' => $userId]);
            if ($record->points < $points) {
                throw new Exception('Insufficient points');
            }
            $record->decrement('points', $points);
            return $record;
        });
    }

    public function getPoints(int $userId): int
    {
        return LoyaltyPoint::where('user_id', $userId)->value('points') ?? 0;
    }
}
