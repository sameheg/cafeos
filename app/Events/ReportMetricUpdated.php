<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ReportMetricUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The metric key.
     *
     * @var string
     */
    public $metric;

    /**
     * The metric payload.
     *
     * @var mixed
     */
    public $data;

    /**
     * Create a new event instance.
     */
    public function __construct(string $metric, $data)
    {
        $this->metric = $metric;
        $this->data = $data;
    }

    /**
     * Get the channels the event should broadcast on.
     */
    public function broadcastOn(): Channel
    {
        return new Channel('report-metrics');
    }
}

