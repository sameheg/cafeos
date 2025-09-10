<?php

namespace Modules\Rentals\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Modules\Membership\Enums\MemberRole;
use Modules\Rentals\Enums\ListingType;
use Modules\Rentals\Models\Listing;

class ListingController extends Controller
{
    public function index()
    {
        return Listing::all();
    }

    public function store(Request $request)
    {
        $user = $request->user();

        $isAdvertiser = DB::table('memberships')
            ->where('user_id', $user->id)
            ->where('role', MemberRole::ADVERTISER->value)
            ->exists();

        abort_unless($isAdvertiser, 403);

        $data = $request->validate([
            'type' => ['required', Rule::in(array_column(ListingType::cases(), 'value'))],
            'title' => ['required', 'string'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric'],
        ]);

        $data['user_id'] = $user->id;

        $listing = Listing::create($data);

        return response()->json($listing, 201);
    }
}
