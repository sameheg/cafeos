<?php

namespace Modules\Dashboard\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DashboardAlertTriggered implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public string $kpi, public float $value)
    {
    }

    public function broadcastOn(): Channel
    {
        return new Channel('dashboard.alerts');
    }

    public function broadcastAs(): string
    {
        return 'dashboard.alert.triggered';
    }

    public function broadcastWith(): array
    {
        return ['kpi' => $this->kpi, 'value' => $this->value];
    }
}
