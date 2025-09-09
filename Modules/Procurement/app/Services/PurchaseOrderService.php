<?php

namespace Modules\Procurement\Services;

use Modules\Procurement\Models\PurchaseOrder;
use Modules\Core\Contracts\InventoryServiceInterface;

class PurchaseOrderService
{
    public function __construct(private InventoryServiceInterface $inventory)
    {
    }

    public function createOrder(array $data): PurchaseOrder
    {
        $data['status'] = $data['status'] ?? 'pending';
        return PurchaseOrder::create($data);
    }

    public function completeOrder(PurchaseOrder $order): void
    {
        $this->inventory->restock($order->items ?? []);
        $order->status = 'completed';
        $order->save();
    }
}

