<?php

namespace Modules\Crm\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Modules\Crm\Models\SurveyResponse;

class LowSurveyScore
{
    use Dispatchable;

    public function __construct(public SurveyResponse $response)
    {
    }
}
