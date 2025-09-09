<?php

namespace Modules\Inventory\Services;

use Modules\Core\Contracts\InventoryServiceInterface;
use Modules\Inventory\Events\LowStockAlert;
use Modules\Inventory\Models\InventoryItem;
use Modules\Inventory\Models\StockMovement;

class InventoryService implements InventoryServiceInterface
{
    public function deductStock($items, string $method = 'FIFO'): void
    {
        foreach ($items as $itemData) {
            $itemId = is_array($itemData) ? $itemData['id'] : $itemData->id;
            $qty = is_array($itemData) ? $itemData['quantity'] : $itemData->quantity;

            $item = InventoryItem::find($itemId);
            if (!$item) {
                continue;
            }

            $movements = StockMovement::where('inventory_item_id', $item->id)
                ->where('type', 'in')
                ->where('remaining_quantity', '>', 0)
                ->orderBy('created_at', $method === 'LIFO' ? 'desc' : 'asc')
                ->orderBy('id', $method === 'LIFO' ? 'desc' : 'asc')
                ->get();

            foreach ($movements as $movement) {
                if ($qty <= 0) {
                    break;
                }

                $deduct = min($movement->remaining_quantity, $qty);
                $movement->remaining_quantity -= $deduct;
                $movement->save();

                StockMovement::create([
                    'tenant_id' => $item->tenant_id,
                    'inventory_item_id' => $item->id,
                    'type' => 'out',
                    'quantity' => -$deduct,
                    'unit_cost' => $movement->unit_cost,
                ]);

                $item->quantity -= $deduct;
                $qty -= $deduct;
            }

            $item->save();

            if ($item->quantity <= $item->alert_threshold) {
                event(new LowStockAlert($item));
            }
        }
    }

    public function restock($items): void
    {
        foreach ($items as $itemData) {
            $itemId = is_array($itemData) ? $itemData['id'] : $itemData->id;
            $qty = is_array($itemData) ? $itemData['quantity'] : $itemData->quantity;
            $unitCost = is_array($itemData) ? ($itemData['unit_cost'] ?? 0) : ($itemData->unit_cost ?? 0);

            $item = InventoryItem::find($itemId);
            if (!$item) {
                continue;
            }

            $item->quantity += $qty;
            $item->save();

            StockMovement::create([
                'tenant_id' => $item->tenant_id,
                'inventory_item_id' => $item->id,
                'type' => 'in',
                'quantity' => $qty,
                'remaining_quantity' => $qty,
                'unit_cost' => $unitCost,
            ]);

            if ($item->quantity <= $item->alert_threshold) {
                event(new LowStockAlert($item));
            }
        }
    }
}
