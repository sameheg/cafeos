<?php

namespace App\Listeners;

use App\Events\RecipeChanged;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class UpdateInventoryOnRecipeChanged
{
    /**
     * Handle the event.
     */
    public function handle(RecipeChanged $event): void
    {
        $recipe = $event->recipe->load('ingredients');

        $url = config('services.inventory.agent_url');

        if (empty($url)) {
            Log::warning('Inventory agent URL not configured for recipe change', ['recipe_id' => $recipe->id]);
            return;
        }

        try {
            Http::post(rtrim($url, '/') . '/recipes/sync', [
                'id' => $recipe->id,
                'product_id' => $recipe->product_id,
                'variation_id' => $recipe->variation_id,
                'ingredients' => $recipe->ingredients->map(function ($ingredient) {
                    return [
                        'variation_id' => $ingredient->variation_id,
                        'quantity' => $ingredient->quantity,
                        'waste_percent' => $ingredient->waste_percent,
                        'sub_unit_id' => $ingredient->sub_unit_id,
                    ];
                })->toArray(),
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to notify inventory agent about recipe change', [
                'recipe_id' => $recipe->id,
                'message' => $e->getMessage(),
            ]);
        }
    }
}

