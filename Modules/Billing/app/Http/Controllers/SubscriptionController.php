<?php

namespace Modules\Billing\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Billing\Models\Subscription;

class SubscriptionController extends Controller
{
    public function index()
    {
        return response()->json(
            Subscription::with('plan')->get()
        );
    }
}
