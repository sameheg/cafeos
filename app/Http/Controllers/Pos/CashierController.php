<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;

class CashierController extends Controller
{
    /**
     * Display the cashier interface.
     */
    public function index()
    {
        return view('livewire.pos.cashier');
    }
}
