<?php

namespace Modules\EventManagement\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Modules\EventManagement\Models\Event;
use Modules\EventManagement\Services\WaitlistService;

class WaitlistController
{
    public function show(Event $event, WaitlistService $waitlist): JsonResponse
    {
        return response()->json(['waitlist' => $waitlist->get($event->id)]);
    }
}
