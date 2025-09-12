<?php

namespace Modules\FoodSafety\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Modules\FoodSafety\Models\FoodSafetyLog;

class BreachDetected
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public FoodSafetyLog $log)
    {
    }

    public function payload(): array
    {
        return [
            'event' => 'foodsafety.breach.detected',
            'data' => [
                'item_id' => (string) $this->log->item_id,
                'temp' => (float) $this->log->temp,
            ],
        ];
    }
}
