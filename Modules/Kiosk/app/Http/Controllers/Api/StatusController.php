<?php

namespace Modules\Kiosk\Http\Controllers\Api;

use Illuminate\Routing\Controller;
use Modules\Kiosk\Models\Kiosk;

class StatusController extends Controller
{
    public function show(Kiosk $kiosk)
    {
        $depth = $kiosk->orders()->where('status', 'queued')->count();

        return response()->json(['queue_depth' => $depth]);
    }
}
