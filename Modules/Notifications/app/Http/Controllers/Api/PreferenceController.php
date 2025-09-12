<?php

namespace Modules\Notifications\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Modules\Notifications\Http\Requests\UpdatePreferenceRequest;
use Modules\Notifications\Models\NotificationPreference;

class PreferenceController extends Controller
{
    public function update(UpdatePreferenceRequest $request)
    {
        $tenantId = app()->bound('tenant') ? app('tenant')->id : null;
        NotificationPreference::updateOrCreate(
            [
                'tenant_id' => $tenantId,
                'user_id' => auth()->id(),
                'channel' => $request->string('channel'),
            ],
            [
                'opt_out' => $request->boolean('opt_out'),
            ]
        );

        return response()->json(['updated' => true]);
    }
}
