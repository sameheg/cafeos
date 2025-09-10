<?php

namespace Modules\Crm\Services;

use Modules\Crm\Models\SurveyResponse;

class NpsAnalyticsService
{
    public function calculateForBranch(int $branchId): float
    {
        $responses = SurveyResponse::where('branch_id', $branchId)->get();
        if ($responses->isEmpty()) {
            return 0.0;
        }

        $total = $responses->count();
        $promoters = $responses->where('rating', '>=', 9)->count();
        $detractors = $responses->where('rating', '<=', 6)->count();

        return (($promoters - $detractors) / $total) * 100;
    }
}
