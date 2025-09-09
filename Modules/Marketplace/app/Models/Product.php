<?php

namespace Modules\Marketplace\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Inventory\Models\InventoryItem;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'inventory_item_id',
        'vendor_id',
        'price',
        'description',
    ];

    public function inventoryItem()
    {
        return $this->belongsTo(InventoryItem::class);
    }
}
