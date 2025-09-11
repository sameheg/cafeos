<?php

namespace Modules\Core\Listeners;

use Modules\Core\Events\ModuleToggled;
use Modules\Core\Events\TenantCreated;
use Modules\Core\Models\OutboxEvent;

class RecordOutboxEvent
{
    public function subscribe(): array
    {
        return [
            TenantCreated::class => 'handleTenantCreated',
            ModuleToggled::class => 'handleModuleToggled',
        ];
    }

    public function handleTenantCreated(TenantCreated $event): void
    {
        OutboxEvent::create([
            'tenant_id' => $event->tenant->id,
            'event' => 'TenantCreated',
            'payload' => ['tenant_id' => $event->tenant->id],
        ]);
    }

    public function handleModuleToggled(ModuleToggled $event): void
    {
        OutboxEvent::create([
            'tenant_id' => $event->tenant->id,
            'event' => 'ModuleToggled',
            'payload' => ['module' => $event->module, 'enabled' => $event->enabled],
        ]);
    }
}
