<?php

namespace Modules\FoodSafety\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Modules\FoodSafety\Models\IngredientInfo;

class IngredientExpiring
{
    use Dispatchable, SerializesModels;

    public function __construct(public IngredientInfo $info) {}
}
