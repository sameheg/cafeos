<?php

namespace Modules\Inventory\Models;

use App\Models\TenantModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Inventory\Events\InventoryCacheInvalidated;

class InventoryItem extends TenantModel
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'name',
        'sku',
        'quantity',
        'alert_threshold',
        'cost_per_unit',
    ];

    protected $dispatchesEvents = [
        'created' => InventoryCacheInvalidated::class,
        'updated' => InventoryCacheInvalidated::class,
        'deleted' => InventoryCacheInvalidated::class,
    ];

    public function stockMovements(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(StockMovement::class);
    }
}
