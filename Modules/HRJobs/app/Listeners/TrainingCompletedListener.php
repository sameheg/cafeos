<?php

namespace Modules\HRJobs\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Cache;

class TrainingCompletedListener implements ShouldQueue
{
    public $tries = 2;

    public $backoff = [1, 2]; // exponential

    public function handle(object $event): void
    {
        $key = 'training.completed:' . $event->employee_id;

        if (Cache::has($key)) {
            return; // idempotent
        }

        Cache::put($key, true, now()->addDay());

        // Placeholder: link training completion to employee profile
    }
}

