<?php

namespace App\Listeners;

use Stancl\Tenancy\Events\TenancyEnded;
use Stancl\Tenancy\Events\TenancyInitialized;

class PrefixQueueWithTenant
{
    /**
     * Prefix or reset queue names based on the tenant context.
     */
    public function handle(TenancyInitialized|TenancyEnded $event): void
    {
        $connections = config('queue.connections', []);

        foreach ($connections as $name => $settings) {
            if (! isset($settings['queue_base'])) {
                continue;
            }

            $queue = $settings['queue_base'];

            if ($event instanceof TenancyInitialized) {
                $queue = $event->tenant->getTenantKey().'-'.$queue;
            }

            config(["queue.connections.$name.queue" => $queue]);
        }
    }
}
