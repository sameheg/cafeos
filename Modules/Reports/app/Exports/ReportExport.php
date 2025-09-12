<?php

namespace Modules\Reports\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Modules\Reports\Models\Report;

class ReportExport implements FromArray
{
    public function __construct(private Report $report)
    {
    }

    public function array(): array
    {
        return [$this->report->data];
    }
}
