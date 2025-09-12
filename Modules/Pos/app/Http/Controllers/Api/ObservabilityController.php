<?php

namespace Modules\Pos\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class ObservabilityController
{
    public function health(): JsonResponse {
        try { DB::select('select 1'); $db='ok'; } catch (\Throwable $e) { $db='fail'; }
        return response()->json(['status'=>'ok','db'=>$db,'time'=>now()->toIso8601String()]);
    }

    public function metrics(): JsonResponse {
        $orders = DB::table('pos_orders')->count();
        $sales = DB::table('pos_orders')->sum('total');
        return response()->json(['orders_total'=>$orders,'sales_total'=>$sales]);
    }
}
