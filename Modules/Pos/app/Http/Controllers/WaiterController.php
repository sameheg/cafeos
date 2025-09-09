<?php

namespace Modules\Pos\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Pos\Models\Order;
use Modules\Pos\Services\BillingService;

class WaiterController extends Controller
{
    public function index()
    {
        return view('pos::waiter.index');
    }

    public function move(Order $order)
    {
        // Placeholder for moving orders between tables
        return back();
    }

    public function split(Order $order, BillingService $billing)
    {
        $billing->splitBill($order, 2);
        return back();
    }
}
