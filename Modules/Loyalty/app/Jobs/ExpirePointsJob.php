<?php

namespace Modules\Loyalty\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\Loyalty\Models\LoyaltyPoint;

class ExpirePointsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(): void
    {
        LoyaltyPoint::where('expiry', '<', now())
            ->where('balance', '>', 0)
            ->chunkById(100, function ($points) {
                foreach ($points as $wallet) {
                    $wallet->balance = 0;
                    $wallet->save();
                }
            });
    }
}
