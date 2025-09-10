<?php

namespace Modules\Franchise\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Franchise\Models\Franchise;

class FranchiseController extends Controller
{
    public function index()
    {
        return Franchise::all();
    }

    public function store(Request $request)
    {
        $user = $request->user();

        $data = $request->validate([
            'tenant_id' => ['required', 'integer'],
            'name' => ['required', 'string'],
            'description' => ['nullable', 'string'],
            'fee' => ['nullable', 'numeric'],
        ]);

        $data['user_id'] = $user->id;

        $franchise = Franchise::create($data);

        return response()->json($franchise, 201);
    }
}
