<?php

namespace Modules\Inventory\Models;

use App\Models\TenantModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StockMovement extends TenantModel
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'inventory_item_id',
        'type',
        'quantity',
        'remaining_quantity',
        'unit_cost',
    ];

    public function item(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(InventoryItem::class, 'inventory_item_id');
    }
}
