<?php

namespace App\Listeners;

use App\Events\TenantCreated;

class ProvisionTenantQueue
{
    public function handle(TenantCreated $event): void
    {
        // Dispatch a simple job to tenant aware connection
        dispatch(function () use ($event) {
            logger()->info('Provisioning tenant: ' . $event->tenant->id);
        })->onConnection('tenant');
    }
}
