<?php

namespace Modules\Inventory\Models;

use App\Models\TenantModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    public function stockMovements(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(StockMovement::class);
    }
}
