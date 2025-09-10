<?php

namespace Modules\Billing\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Billing\Models\Subscription;
use Modules\Billing\Models\Plan;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    public function index()
    {
        $subscriptions = Subscription::with('plan')->get();

        return view('billing::subscriptions.index', compact('subscriptions'));
    }

    public function store(Request $request, Plan $plan)
    {
        $tenant = Auth::user()->tenant;

        $tenant->newSubscription('default', $plan->stripe_price_id)->create($request->payment_method);

        return redirect()->route('billing.subscriptions.index');
    }
}
