<?php

namespace Modules\SuperAdmin\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ModuleDisabled
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public string $module, public ?string $tenantId)
    {
    }

    public function broadcastWith(): array
    {
        return [
            'event' => 'superadmin.module.disabled@v1',
            'data' => [
                'module' => $this->module,
                'tenant_id' => $this->tenantId,
            ],
        ];
    }
}
