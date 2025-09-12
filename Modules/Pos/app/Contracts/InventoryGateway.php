<?php
namespace Modules\Pos\App\Contracts;

interface InventoryGateway {
    /**
     * يحجز/يخصم المخزون للطلب عند الدفع
     */
    public function consumeItems(array $items, array $meta = []): bool;
}
