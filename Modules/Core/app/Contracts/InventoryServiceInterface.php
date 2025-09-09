<?php

namespace Modules\Core\Contracts;

interface InventoryServiceInterface
{
    public function deductStock($items, string $method = 'FIFO'): void;

    public function restock($items): void;
}
