<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;

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

        $results = collect();

        if (!empty($query)) {
            $results = User::where('first_name', 'like', "%{$query}%")
                ->orWhere('surname', 'like', "%{$query}%")
                ->orWhere('username', 'like', "%{$query}%")
                ->limit(5)
                ->get()
                ->map(function ($user) {
                    return [
                        'id' => $user->id,
                        'name' => trim($user->surname . ' ' . $user->first_name),
                        'url' => url('/user/profile'),
                    ];
                });
        }

        return response()->json($results);
    }
}

