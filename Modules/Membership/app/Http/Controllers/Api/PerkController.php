<?php

namespace Modules\Membership\Http\Controllers\Api;

use Illuminate\Routing\Controller;
use Modules\Membership\Models\MembershipPerk;

class PerkController extends Controller
{
    public function show(string $tier)
    {
        $perks = MembershipPerk::where('tier', $tier)->pluck('description');

        if ($perks->isEmpty()) {
            abort(404);
        }

        return ['perks' => $perks->all()];
    }
}
