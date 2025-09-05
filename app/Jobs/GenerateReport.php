<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class GenerateReport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Send the job to the reports queue on the Redis connection.
     */
    public string $connection = 'redis';
    public string $queue = 'reports';
    public int $tries = 3;

    protected string $type;

    public function __construct(string $type)
    {
        $this->type = $type;
    }

    public function handle(): void
    {
        Log::info('Generating report', ['type' => $this->type]);
    }
}
