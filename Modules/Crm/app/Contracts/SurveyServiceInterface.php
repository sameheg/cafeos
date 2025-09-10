<?php

namespace Modules\Crm\Contracts;

use Modules\Crm\Models\Survey;
use Modules\Crm\Models\SurveyResponse;

interface SurveyServiceInterface
{
    public function createSurvey(int $tenantId, int $branchId, string $question): Survey;

    public function submitResponse(int $surveyId, int $branchId, int $rating, ?string $comment = null): SurveyResponse;
}
