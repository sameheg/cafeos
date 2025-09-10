<?php

namespace Modules\FoodSafety\Models;

use App\Models\TenantModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IngredientInfo extends TenantModel
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'inventory_item_id',
        'expiry_date',
        'allergens',
    ];

    protected $casts = [
        'expiry_date' => 'date',
        'allergens' => 'array',
    ];

    public function inventoryItem(): BelongsTo
    {
        return $this->belongsTo(\Modules\Inventory\Models\InventoryItem::class);
    }

    public function isExpired(): bool
    {
        return $this->expiry_date !== null && $this->expiry_date->isPast();
    }

    public function isExpiringSoon(int $days = 3): bool
    {
        if ($this->expiry_date === null) {
            return false;
        }
        $now = now();
        return $this->expiry_date->isAfter($now) && $this->expiry_date->isBefore($now->copy()->addDays($days));
    }
}
