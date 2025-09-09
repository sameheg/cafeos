<?php

namespace Modules\Marketplace\Services;

use Modules\Reports\Contracts\ReportGenerator;

class MarketplaceReportGenerator implements ReportGenerator
{
    public function generate(array $filters): array
    {
        return [
            ['module' => 'marketplace']
        ];
    }
}
