<?php

namespace Modules\Notifications\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Modules\Notifications\Http\Requests\SendNotificationRequest;
use Modules\Notifications\Models\NotificationTemplate;
use Modules\Notifications\Services\NotificationSender;

class NotificationController extends Controller
{
    public function store(SendNotificationRequest $request, NotificationSender $sender)
    {
        $tenantId = app()->bound('tenant') ? app('tenant')->id : null;
        $template = NotificationTemplate::where('tenant_id', $tenantId)
            ->where('name', $request->string('template'))
            ->firstOrFail();

        $notifId = $sender->send(
            $template,
            $request->input('recipients'),
            $request->input('channel', 'mail')
        );

        return response()->json(['notif_id' => $notifId]);
    }
}
