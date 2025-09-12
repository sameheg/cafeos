<?php

namespace Modules\SuperAdmin\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\SuperAdmin\Http\Requests\BroadcastRequest;
use Modules\SuperAdmin\Jobs\BroadcastMessageJob;

class BroadcastController extends Controller
{
    public function store(BroadcastRequest $request)
    {
        BroadcastMessageJob::dispatch($request->message);
        return response()->json(['sent' => true]);
    }
}
