<?php

namespace Modules\Crm\Policies;

use Modules\Core\Policies\BasePolicy;
use Modules\Crm\Models\SurveyResponse;

class SurveyResponsePolicy extends BasePolicy
{
    protected static string $model = SurveyResponse::class;
}
