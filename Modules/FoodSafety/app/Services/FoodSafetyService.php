<?php

namespace Modules\FoodSafety\Services;

use Modules\FoodSafety\Events\IngredientExpiring;
use Modules\FoodSafety\Exceptions\ExpiredIngredientException;
use Modules\FoodSafety\Models\IngredientInfo;
use Modules\Inventory\Models\InventoryItem;

class FoodSafetyService
{
    public function ensureNotExpired(InventoryItem $item): void
    {
        $info = IngredientInfo::where('inventory_item_id', $item->id)->first();
        if ($info && $info->isExpired()) {
            throw new ExpiredIngredientException("Inventory item {$item->id} is expired");
        }
    }

    public function checkExpirations(int $days = 3): void
    {
        $infos = IngredientInfo::with('inventoryItem')->get();
        foreach ($infos as $info) {
            if ($info->isExpiringSoon($days)) {
                event(new IngredientExpiring($info));
            }
        }
    }
}
