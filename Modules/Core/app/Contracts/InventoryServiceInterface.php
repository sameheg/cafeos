<?php

namespace Modules\Core\Contracts;

interface InventoryServiceInterface
{
    public function deductStock($items): void;
}
