<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display the payment interface.
     */
    public function index()
    {
        return view('livewire.pos.payment-modal');
    }

    /**
     * Process a payment.
     */
    public function store(Request $request)
    {
        // TODO: implement payment processing
        return response()->json(['status' => 'ok']);
    }
}
