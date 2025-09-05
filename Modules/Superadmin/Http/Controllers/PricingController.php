<?php

namespace Modules\Superadmin\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Superadmin\Entities\Plan;

class PricingController extends Controller
{
    public function index()
    {
        $plans = Plan::all();
        return view('superadmin::pricing.index', compact('plans'));
    }
}
