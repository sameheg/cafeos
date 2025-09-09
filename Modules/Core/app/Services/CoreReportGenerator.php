<?php

namespace Modules\Core\Services;

use Modules\Reports\Contracts\ReportGenerator;

class CoreReportGenerator implements ReportGenerator
{
    public function generate(array $filters): array
    {
        return [
            ['module' => 'core']
        ];
    }
}
