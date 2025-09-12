<?php

namespace Modules\Pos\Services;

use Modules\Pos\Models\PosItem;

class InventoryService
{
    public static function decrementForItem(PosItem $item): void
    {
        // TODO: implement BOM deduction
    }

    public static function reverseForItem(PosItem $item): void
    {
        // TODO: implement BOM reversal
    }
}
