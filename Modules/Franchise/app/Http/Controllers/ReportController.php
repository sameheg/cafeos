<?php

namespace Modules\Franchise\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;
use Modules\Franchise\Models\FranchiseTemplate;

class ReportController extends BaseController
{
    public function show(): JsonResponse
    {
        $data = FranchiseTemplate::query()->get()->toArray();
        if (empty($data)) {
            return response()->json(['error' => 'not-found'], 404);
        }

        return response()->json(['data' => $data]);
    }
}
