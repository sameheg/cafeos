<?php

namespace Modules\HRJobs\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Modules\HRJobs\Models\Payroll;

class PayrollController extends Controller
{
    public function show(string $period): JsonResponse
    {
        $payrolls = Payroll::where('period', $period)->get();

        if ($payrolls->isEmpty()) {
            return response()->json(['message' => 'not found'], 404);
        }

        return response()->json(['data' => $payrolls]);
    }
}

