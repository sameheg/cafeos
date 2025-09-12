<?php

namespace Modules\FloorPlanDesigner\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;
use Modules\FloorPlanDesigner\Models\Furniture;
use Modules\FloorPlanDesigner\Notifications\FloorAlert;

class EvaluateFloorplanAlerts implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public string $planId) {}

    public function handle(): void
    {
        $tables = Furniture::where('plan_id',$this->planId)->where('status','occupied')->get();
        foreach ($tables as $t) {
            // TODO: compute duration & thresholds using POS data
            // Placeholder: notify if capacity > 6
            if (($t->capacity ?? 2) > 6) {
                Notification::route('mail', 'manager@example.com')->notify(new FloorAlert('High capacity table in use: '.$t->name));
            }
        }
    }
}
