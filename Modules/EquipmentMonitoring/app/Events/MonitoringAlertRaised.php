<?php

namespace Modules\EquipmentMonitoring\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class MonitoringAlertRaised implements ShouldBroadcast
{
    use SerializesModels;

    public function __construct(
        public string $equipmentId,
        public string $metric,
        public float $value,
        public string $tenantId
    ) {
    }

    public function broadcastOn(): array
    {
        return [new Channel('monitoring.'.$this->tenantId)];
    }

    public function broadcastAs(): string
    {
        return 'monitoring.alert.raised';
    }

    public function toArray(): array
    {
        return [
            'equipment_id' => $this->equipmentId,
            'metric' => $this->metric,
            'value' => $this->value,
            'tenant_id' => $this->tenantId,
        ];
    }
}
