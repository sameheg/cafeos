<?php

namespace Modules\Pos\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Modules\Pos\Models\PosAudit;

class AuditController
{
    public function index(Request $r): JsonResponse {
        $q = PosAudit::query()->latest();
        if ($t = $r->query('tenant_id')) $q->where('tenant_id',$t);
        if ($e = $r->query('entity_type')) $q->where('entity_type',$e);
        return response()->json(['data'=>$q->paginate(50)]);
    }
}
