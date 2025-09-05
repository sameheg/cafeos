<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use OpenAI\Laravel\Facades\OpenAI;

class MenuSuggestionService
{
    /**
     * Fetch menu suggestions from OpenAI based on top selling products.
     */
    public function getSuggestions(): array
    {
        return Cache::remember('menu_suggestions', 3600, function () {
            $topProducts = DB::table('transaction_sell_lines')
                ->select('products.name', DB::raw('SUM(transaction_sell_lines.quantity) as total'))
                ->join('products', 'transaction_sell_lines.product_id', '=', 'products.id')
                ->groupBy('products.name')
                ->orderByDesc('total')
                ->limit(5)
                ->pluck('products.name')
                ->toArray();

            if (empty($topProducts)) {
                return [];
            }

            $prompt = 'Suggest menu items based on these top-selling products: ' . implode(', ', $topProducts);

            $response = OpenAI::completions()->create([
                'model' => 'gpt-3.5-turbo-instruct',
                'prompt' => $prompt,
                'max_tokens' => 60,
            ]);

            $text = $response['choices'][0]['text'] ?? '';
            $suggestions = array_values(array_filter(array_map('trim', preg_split("/\n+/", $text))));

            return $suggestions;
        });
    }
}
