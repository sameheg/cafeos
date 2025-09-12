<?php

namespace Modules\Pos\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Modules\Pos\Models\PosCustomer;

class CustomerController
{
    public function index(Request $r): JsonResponse {
        $q = PosCustomer::query();
        if ($s = $r->query('s')) $q->where('name','like',"%$s%");
        return response()->json(['data'=>$q->latest()->paginate(20)]);
    }
    public function store(Request $r): JsonResponse {
        $data = $r->validate(['tenant_id'=>'required','name'=>'required','phone'=>'nullable','email'=>'nullable|email','meta'=>'array']);
        $c = PosCustomer::create($data);
        return response()->json(['data'=>$c], 201);
    }
}
