<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ApiToken;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ApiTokenController extends Controller
{
    public function index()
    {
        $tokens = ApiToken::all();
        return view('admin.api_tokens.index', compact('tokens'));
    }

    public function create()
    {
        return view('admin.api_tokens.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:191',
            'scopes' => 'nullable|string',
            'expires_at' => 'nullable|date',
        ]);

        $data['token'] = Str::random(60);
        $data['scopes'] = $data['scopes'] ? array_map('trim', explode(',', $data['scopes'])) : [];

        ApiToken::create($data);

        return redirect()->route('admin.api-tokens.index');
    }

    public function edit(ApiToken $api_token)
    {
        $api_token->scopes = $api_token->scopes ? implode(',', $api_token->scopes) : '';
        return view('admin.api_tokens.edit', compact('api_token'));
    }

    public function update(Request $request, ApiToken $api_token)
    {
        $data = $request->validate([
            'name' => 'required|string|max:191',
            'scopes' => 'nullable|string',
            'expires_at' => 'nullable|date',
        ]);
        $data['scopes'] = $data['scopes'] ? array_map('trim', explode(',', $data['scopes'])) : [];
        $api_token->update($data);

        return redirect()->route('admin.api-tokens.index');
    }

    public function destroy(ApiToken $api_token)
    {
        $api_token->delete();
        return redirect()->route('admin.api-tokens.index');
    }

    public function rotate(ApiToken $api_token)
    {
        $api_token->update(['token' => Str::random(60)]);
        return redirect()->route('admin.api-tokens.index');
    }
}
