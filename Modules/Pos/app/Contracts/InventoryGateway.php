<?php
namespace Modules\Pos\App\Contracts;

interface InventoryGateway {
    public function consumeItems(array $items, array $meta = []): bool;
    public function reserveItems(array $items, array $meta = []): bool;
    public function releaseReservation(array $items, array $meta = []): bool;
}
