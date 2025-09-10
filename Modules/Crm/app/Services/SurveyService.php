<?php

namespace Modules\Crm\Services;

use Modules\Crm\Contracts\SurveyServiceInterface;
use Modules\Crm\Events\LowSurveyScore;
use Modules\Crm\Models\Survey;
use Modules\Crm\Models\SurveyResponse;

class SurveyService implements SurveyServiceInterface
{
    public function createSurvey(int $tenantId, int $branchId, string $question): Survey
    {
        return Survey::create([
            'tenant_id' => $tenantId,
            'branch_id' => $branchId,
            'question' => $question,
        ]);
    }

    public function submitResponse(int $surveyId, int $branchId, int $rating, ?string $comment = null): SurveyResponse
    {
        $survey = Survey::findOrFail($surveyId);

        $response = SurveyResponse::create([
            'tenant_id' => $survey->tenant_id,
            'survey_id' => $surveyId,
            'branch_id' => $branchId,
            'rating' => $rating,
            'comment' => $comment,
        ]);

        if ($rating <= 6) {
            LowSurveyScore::dispatch($response);
        }

        return $response;
    }
}
