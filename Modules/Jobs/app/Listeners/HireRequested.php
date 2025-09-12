<?php

namespace Modules\Jobs\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Jobs\Models\JobApplication;

class HireRequested implements ShouldQueue
{
    public $tries = 3;

    public $backoff = [10, 30, 90];

    public function handle(array $payload): void
    {
        $appId = $payload['app_id'] ?? null;
        if (! $appId) {
            return;
        }

        $application = JobApplication::find($appId);
        if ($application && $application->status !== JobApplication::STATUS_HIRED) {
            $application->hire();
        }
    }
}
