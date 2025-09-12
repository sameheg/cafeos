<?php

namespace Modules\SuperAdmin\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\SuperAdmin\Models\Log;

class BroadcastMessageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public string $message)
    {
    }

    public function handle(): void
    {
        Log::create([
            'action' => 'broadcast_sent',
            'user_id' => null,
            'timestamp' => now(),
            'meta' => ['message' => $this->message],
        ]);
    }
}
