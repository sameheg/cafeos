<?php

namespace App\Http\Controllers;

use App\Services\LoyaltyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoyaltyController extends Controller
{
    protected $service;

    public function __construct(LoyaltyService $service)
    {
        $this->middleware('auth');
        $this->service = $service;
    }

    public function show()
    {
        $points = $this->service->getPoints(Auth::id());
        return view('loyalty.show', compact('points'));
    }

    public function redeem(Request $request)
    {
        $request->validate(['points' => 'required|integer|min:1']);
        $this->service->redeemPoints(Auth::id(), (int) $request->points);
        return redirect()->route('loyalty.show');
    }
}
