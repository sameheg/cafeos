<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Product;
use App\Transaction;

class AdminSearchController extends Controller
{
    /**
     * Handle global search requests.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $query = $request->get('query');

        $results = [
            'users' => [],
            'products' => [],
            'transactions' => [],
        ];

        if (! empty($query)) {
            $results['users'] = User::where('first_name', 'like', "%{$query}%")
                ->orWhere('surname', 'like', "%{$query}%")
                ->orWhere('username', 'like', "%{$query}%")
                ->limit(5)
                ->get()
                ->map(fn ($user) => [
                    'id' => $user->id,
                    'type' => 'user',
                    'name' => trim($user->surname . ' ' . $user->first_name),
                    'url' => url("/users/{$user->id}"),
                ])
                ->toArray();

            $results['products'] = Product::where('name', 'like', "%{$query}%")
                ->orWhere('sku', 'like', "%{$query}%")
                ->limit(5)
                ->get()
                ->map(fn ($product) => [
                    'id' => $product->id,
                    'type' => 'product',
                    'name' => $product->name,
                    'url' => url("/products/{$product->id}/edit"),
                ])
                ->toArray();

            $results['transactions'] = Transaction::where('type', 'sell')
                ->where('invoice_no', 'like', "%{$query}%")
                ->limit(5)
                ->get()
                ->map(fn ($transaction) => [
                    'id' => $transaction->id,
                    'type' => 'transaction',
                    'name' => $transaction->invoice_no,
                    'url' => url("/sells/{$transaction->id}"),
                ])
                ->toArray();
        }

        return response()->json($results);
    }
}

