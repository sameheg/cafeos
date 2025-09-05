<?php

namespace Modules\HR\Reports;

use Modules\HR\Entities\Payroll;

class PayrollReport
{
    public function generate(?string $month = null)
    {
        $query = Payroll::query();
        if ($month) {
            $query->where('month', $month);
        }

        return $query->get();
    }
}
