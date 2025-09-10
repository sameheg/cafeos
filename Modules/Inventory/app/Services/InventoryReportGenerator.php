<?php

namespace Modules\Inventory\Services;

use Modules\Reports\Contracts\ReportGenerator;

class InventoryReportGenerator implements ReportGenerator
{
    public function generate(array $filters): array
    {
        return [
            ['module' => 'inventory'],
        ];
    }
}
