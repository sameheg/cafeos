<?php

namespace Modules\Core\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Modules\Core\Models\Invitation;
use Symfony\Component\HttpFoundation\Response;

class InvitationController
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'role' => 'required',
        ]);

        $tenant = app('currentTenant');
        $invitation = Invitation::create([
            'tenant_id' => $tenant->id,
            'email' => $data['email'],
            'role' => $data['role'],
            'expires_at' => Carbon::now()->addDays(7),
        ]);

        return response()->json(['token' => $invitation->token]);
    }

    public function accept(Request $request)
    {
        $data = $request->validate(['token' => 'required']);
        $invitation = Invitation::where('token', $data['token'])->first();
        if (! $invitation || ($invitation->expires_at && $invitation->expires_at->isPast())) {
            return response()->json([
                'message' => __('core::messages.invitation_invalid'),
            ], Response::HTTP_GONE);
        }

        $invitation->delete();

        return response()->json([
            'message' => __('core::messages.invitation_accepted'),
        ]);
    }
}
