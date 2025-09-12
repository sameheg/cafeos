<?php

namespace Modules\Pos\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class AdvancedReportController
{
    public function pnl(Request $r): JsonResponse {
        $tenant = $r->query('tenant_id');
        $sales = DB::table('pos_orders')->when($tenant, fn($q)=>$q->where('tenant_id',$tenant))->sum('total');
        // NOTE: COGS placeholder (integrate with Inventory)
        $cogs = $sales * 0.4;
        $gross = $sales - $cogs;
        return response()->json(['sales'=>$sales,'cogs'=>$cogs,'gross_profit'=>$gross]);
    }

    public function occupancy(Request $r): JsonResponse {
        // Placeholder occupancy by tables (requires sessions data)
        $tables = DB::table('pos_tables')->count();
        $active = DB::table('pos_tables')->where('status','occupied')->count();
        return response()->json(['tables'=>$tables,'occupied'=>$active,'occupancy_rate'=> $tables and round(($active/$tables)*100,2) ]);
    }
}
