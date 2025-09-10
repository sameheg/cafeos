<?php

namespace Modules\Crm\Services;

use Modules\Reports\Contracts\ReportGenerator;

class CrmReportGenerator implements ReportGenerator
{
    public function generate(array $filters): array
    {
        return [
            ['module' => 'crm'],
        ];
    }
}
