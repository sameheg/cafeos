<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Product;
use Illuminate\Http\Request;

/**
 * @group Products
 * @authenticated
 *
 * APIs for managing products
 */
class ProductApiController extends Controller
{
    public function index()
    {
        return ProductResource::collection(Product::paginate());
    }

    public function store(Request $request)
    {
        $product = Product::create($request->all());

        return new ProductResource($product);
    }

    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    public function update(Request $request, Product $product)
    {
        $product->update($request->all());

        return new ProductResource($product);
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return response()->noContent();
    }
}
