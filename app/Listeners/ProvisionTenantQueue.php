<?php

namespace App\Listeners;

use App\Events\TenantCreated;
use Illuminate\Support\Facades\Log;

class ProvisionTenantQueue
{
    public function handle(TenantCreated $event): void
    {
        Log::info('Provisioning queue for tenant '.$event->tenant->id);
    }
}
