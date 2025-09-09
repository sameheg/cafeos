<?php

namespace Modules\Pos\Services;

use Modules\Pos\Models\Order;

class IntegrationService
{
    public function syncInventory(Order $order): void
    {
        // Placeholder for inventory synchronization
    }

    public function syncCrm(Order $order): void
    {
        // Placeholder for CRM synchronization
    }

    public function syncReports(Order $order): void
    {
        // Placeholder for reporting synchronization
    }

    public function syncOffline(Order $order): void
    {
        // Placeholder for offline synchronization
    }
}
