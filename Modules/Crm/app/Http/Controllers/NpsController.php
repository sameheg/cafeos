<?php

namespace Modules\Crm\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Crm\Services\NpsAnalyticsService;

class NpsController extends Controller
{
    public function __construct(private NpsAnalyticsService $analytics)
    {
    }

    public function show(int $branch)
    {
        return response()->json([
            'branch_id' => $branch,
            'nps' => $this->analytics->calculateForBranch($branch),
        ]);
    }
}
