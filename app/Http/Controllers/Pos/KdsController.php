<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;

class KdsController extends Controller
{
    /**
     * Display the kitchen display system.
     */
    public function index()
    {
        return view('livewire.pos.kds');
    }
}
