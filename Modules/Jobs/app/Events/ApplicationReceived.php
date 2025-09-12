<?php

namespace Modules\Jobs\Events;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Modules\Jobs\Models\JobApplication;

class ApplicationReceived
{
    use Dispatchable, Queueable, SerializesModels;

    public function __construct(public JobApplication $application) {}

    public function toArray(): array
    {
        return [
            'app_id' => $this->application->id,
            'job_id' => $this->application->posting_id,
        ];
    }
}
