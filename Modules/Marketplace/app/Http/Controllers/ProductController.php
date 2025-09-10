<?php

namespace Modules\Marketplace\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Marketplace\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        return Product::all();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'inventory_item_id' => ['required','integer'],
            'vendor_id' => ['required','integer'],
            'price' => ['required','numeric'],
            'description' => ['nullable','string'],
        ]);

        $product = Product::create($data);

        return response()->json($product, 201);
    }
}
