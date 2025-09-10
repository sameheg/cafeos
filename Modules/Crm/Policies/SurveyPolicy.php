<?php

namespace Modules\Crm\Policies;

use Modules\Core\Policies\BasePolicy;
use Modules\Crm\Models\Survey;

class SurveyPolicy extends BasePolicy
{
    protected static string $model = Survey::class;
}
