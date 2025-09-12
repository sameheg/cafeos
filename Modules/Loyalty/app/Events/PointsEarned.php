<?php

namespace Modules\Loyalty\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PointsEarned implements ShouldBroadcast
{
    use Dispatchable, SerializesModels;

    public function __construct(public string $customerId, public int $points)
    {
    }

    public function broadcastOn(): Channel
    {
        return new Channel('loyalty');
    }

    public function broadcastAs(): string
    {
        return 'loyalty.points.earned';
    }

    public function broadcastWith(): array
    {
        return [
            'customer_id' => $this->customerId,
            'points' => $this->points,
        ];
    }
}
