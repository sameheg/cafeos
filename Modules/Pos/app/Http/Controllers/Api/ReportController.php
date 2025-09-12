<?php

namespace Modules\Pos\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class ReportController
{
    public function daily(Request $r): JsonResponse {
        $tenant = $r->query('tenant_id');
        $day = $r->query('date', now()->toDateString());
        $sales = DB::table('pos_orders')->whereDate('created_at',$day)->when($tenant, fn($q)=>$q->where('tenant_id',$tenant))->sum('total');
        $count = DB::table('pos_orders')->whereDate('created_at',$day)->when($tenant, fn($q)=>$q->where('tenant_id',$tenant))->count();
        return response()->json(['date'=>$day,'sales'=>$sales,'orders'=>$count,'avg_ticket'=>$count?($sales/$count):0]);
    }

    public function topItems(Request $r): JsonResponse {
        $tenant = $r->query('tenant_id');
        $rows = DB::table('pos_items')->select('name', DB::raw('SUM(qty) as qty'), DB::raw('SUM(qty*price) as revenue'))->when($tenant, fn($q)=>$q->where('tenant_id',$tenant))->groupBy('name')->orderByDesc('revenue')->limit(20)->get();
        return response()->json(['data'=>$rows]);
    }
}
