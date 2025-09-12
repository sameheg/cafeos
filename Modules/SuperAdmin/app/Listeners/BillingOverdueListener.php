<?php

namespace Modules\SuperAdmin\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Modules\SuperAdmin\Models\Flag;

class BillingOverdueListener implements ShouldQueue
{
    use InteractsWithQueue;

    public $tries = 1;

    public function handle($payload): void
    {
        $tenantId = $payload['tenant_id'] ?? null;
        if ($tenantId) {
            Flag::updateOrCreate(
                ['module' => $payload['module'] ?? '*', 'tenant_id' => $tenantId],
                ['enabled' => false]
            );
        }
    }
}
