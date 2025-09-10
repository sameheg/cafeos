<?php

namespace Modules\FoodSafety\Policies;

use Modules\Core\Policies\BasePolicy;
use Modules\FoodSafety\Models\IngredientInfo;

class IngredientInfoPolicy extends BasePolicy
{
    protected static string $model = IngredientInfo::class;
}
