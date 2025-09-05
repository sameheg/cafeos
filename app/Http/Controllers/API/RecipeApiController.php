<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\MfgRecipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RecipeApiController extends Controller
{
    public function sync(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'product_id' => 'required|integer|exists:products,id',
                'variation_id' => 'required|integer',
                'ingredients' => 'required|array|min:1',
                'ingredients.*.variation_id' => 'required|integer|exists:variations,id',
                'ingredients.*.quantity' => 'required|numeric',
            ],
            [
                'ingredients.*.variation_id.exists' => 'Ingredient variation :input does not exist.',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $recipe = DB::transaction(function () use ($request) {
            $recipe = MfgRecipe::updateOrCreate(
                ['product_id' => $request->product_id],
                [
                    'variation_id' => $request->variation_id,
                    'instructions' => $request->instructions,
                    'waste_percent' => $request->waste_percent ?? 0,
                    'ingredients_cost' => $request->ingredients_cost ?? 0,
                    'extra_cost' => $request->extra_cost ?? 0,
                    'total_quantity' => $request->total_quantity ?? 1,
                    'final_price' => $request->final_price ?? 0,
                    'sub_unit_id' => $request->sub_unit_id,
                ]
            );

            $recipe->ingredients()->delete();

            foreach ($request->ingredients as $ingredient) {
                $recipe->ingredients()->create([
                    'variation_id' => $ingredient['variation_id'],
                    'quantity' => $ingredient['quantity'],
                    'waste_percent' => $ingredient['waste_percent'] ?? 0,
                    'sub_unit_id' => $ingredient['sub_unit_id'] ?? null,
                ]);
            }

            return $recipe;
        });

        return response()->json(['message' => 'Recipe synced successfully', 'id' => $recipe->id]);
    }
}

