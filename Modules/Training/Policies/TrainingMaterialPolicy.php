<?php

namespace Modules\Training\Policies;

use Modules\Core\Policies\BasePolicy;
use Modules\Training\Models\TrainingMaterial;

class TrainingMaterialPolicy extends BasePolicy
{
    protected static string $model = TrainingMaterial::class;
}
