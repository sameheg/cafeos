<?php

namespace Modules\FoodSafety\Observers;

use Illuminate\Support\Facades\Event;
use Modules\FoodSafety\Events\BreachDetected;
use Modules\FoodSafety\Models\FoodSafetyLog;
use Modules\FoodSafety\Services\ThresholdChecker;

class FoodSafetyLogObserver
{
    public function created(FoodSafetyLog $log): void
    {
        $checker = app(ThresholdChecker::class);
        if ($checker->isBreach($log->temp)) {
            $log->status = 'alerted';
            $log->save();
            Event::dispatch(new BreachDetected($log));
        }
    }
}
