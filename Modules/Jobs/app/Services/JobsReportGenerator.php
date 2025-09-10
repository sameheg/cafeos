<?php

namespace Modules\Jobs\Services;

use Modules\Reports\Contracts\ReportGenerator;

class JobsReportGenerator implements ReportGenerator
{
    public function generate(array $filters): array
    {
        return [
            ['module' => 'jobs'],
        ];
    }
}
