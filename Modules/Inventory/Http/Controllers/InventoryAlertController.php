<?php

namespace Modules\Inventory\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Inventory\Entities\InventoryAlert;

class InventoryAlertController extends Controller
{
    public function index()
    {
        $alerts = InventoryAlert::with('product')->latest()->get();

        return view('admin.alerts', compact('alerts'));
    }
}
