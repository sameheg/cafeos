<?php
namespace Modules\Pos\App\Contracts;

interface InventoryGateway {
    public function consumeItems(array $items, array $meta = []): bool;
}
