<?php

namespace Modules\Training\Policies;

use Modules\Core\Policies\BasePolicy;
use Modules\Training\Models\TrainingCompletion;

class TrainingCompletionPolicy extends BasePolicy
{
    protected static string $model = TrainingCompletion::class;
}
