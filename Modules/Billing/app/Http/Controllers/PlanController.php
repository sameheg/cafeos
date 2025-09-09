<?php

namespace Modules\Billing\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Billing\Models\Plan;

class PlanController extends Controller
{
    public function index()
    {
        return response()->json(Plan::all());
    }
}
