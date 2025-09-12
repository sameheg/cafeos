<?php

namespace Modules\Membership\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Membership\Models\Membership;

class MembershipController extends Controller
{
    public function update(Request $request, Membership $membership)
    {
        $validated = $request->validate([
            'tier' => 'required|string',
        ]);

        $membership->tier = $validated['tier'];
        $membership->save();

        return ['updated' => true];
    }
}
