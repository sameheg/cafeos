<?php

namespace Modules\Jobs\Observers;

use Modules\Jobs\Events\ApplicationReceived;
use Modules\Jobs\Models\JobApplication;

class JobApplicationObserver
{
    public function created(JobApplication $application): void
    {
        ApplicationReceived::dispatch($application);
    }
}
