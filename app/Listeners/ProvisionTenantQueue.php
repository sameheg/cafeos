<?php

namespace App\Listeners;

use App\Events\TenantCreated;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProvisionTenantQueue implements ShouldQueue
{
    public function handle(TenantCreated $event): void
    {
        // Setup tenant-specific queues or infrastructure
    }
}
