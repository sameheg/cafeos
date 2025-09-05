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
            'users' => collect(),
            'products' => collect(),
            'invoices' => collect(),
        ];

        if (! empty($query)) {
            $results['users'] = User::where('first_name', 'like', "%{$query}%")
                ->orWhere('surname', 'like', "%{$query}%")
                ->orWhere('username', 'like', "%{$query}%")
                ->limit(5)
                ->get()
                ->map(function ($user) {
                    return [
                        'id' => $user->id,
                        'name' => trim($user->surname . ' ' . $user->first_name),
                        'url' => url('/user/profile'),
                        'type' => 'user',
                    ];
                })
                ->values();

            $results['products'] = Product::where('name', 'like', "%{$query}%")
                ->orWhere('sku', 'like', "%{$query}%")
                ->limit(5)
                ->get()
                ->map(function ($product) {
                    return [
                        'id' => $product->id,
                        'name' => $product->name,
                        'url' => action([\App\Http\Controllers\ProductController::class, 'edit'], [$product->id]),
                        'type' => 'product',
                    ];
                })
                ->values();

            $results['invoices'] = Transaction::where('type', 'sell')
                ->where('invoice_no', 'like', "%{$query}%")
                ->limit(5)
                ->get()
                ->map(function ($transaction) {
                    return [
                        'id' => $transaction->id,
                        'name' => $transaction->invoice_no,
                        'url' => action([\App\Http\Controllers\SellController::class, 'show'], [$transaction->id]),
                        'type' => 'invoice',
                    ];
                })
                ->values();
        }

        return response()->json($results);
    }
}

