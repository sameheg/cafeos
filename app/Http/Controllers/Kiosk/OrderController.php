<?php

namespace App\Http\Controllers\Kiosk;

use App\Http\Controllers\Controller;
use App\Http\Controllers\SellPosController;
use App\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display kiosk product list.
     */
    public function index()
    {
        $products = Product::select('id', 'name')->get();
        return view('kiosk.index', compact('products'));
    }

    /**
     * Forward order request to SellPosController.
     */
    public function store(Request $request, SellPosController $sellPos)
    {
        return $sellPos->store($request);
    }
}
