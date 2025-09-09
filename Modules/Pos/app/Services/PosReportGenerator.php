<?php

namespace Modules\Pos\Services;

use Modules\Reports\Contracts\ReportGenerator;

class PosReportGenerator implements ReportGenerator
{
    public function generate(array $filters): array
    {
        return [
            ['module' => 'pos']
        ];
    }
}
