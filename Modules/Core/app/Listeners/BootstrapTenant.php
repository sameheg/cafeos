<?php

namespace Modules\Core\Listeners;

use Modules\Core\Events\TenantCreated;

class BootstrapTenant
{
    public function handle(TenantCreated $event): void
    {
        $event->tenant->modules()->firstOrCreate(
            ['module' => 'core'],
            ['enabled' => true]
        );
    }
}
