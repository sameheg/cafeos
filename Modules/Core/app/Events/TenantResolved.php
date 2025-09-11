<?php

namespace Modules\Core\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TenantResolved
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public string $tenant_id)
    {
    }

    public function broadcastAs(): string
    {
        return 'core.tenant.resolved';
    }
}
