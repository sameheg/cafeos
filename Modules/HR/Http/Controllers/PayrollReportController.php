<?php

namespace Modules\HR\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\HR\Reports\PayrollReport;

class PayrollReportController extends Controller
{
    public function monthly(Request $request)
    {
        $month = $request->input('month');
        $report = new PayrollReport();

        return $report->generate($month);
    }
}
