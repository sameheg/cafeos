<?php

namespace Modules\Inventory\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class InventoryBatch extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = [
        'tenant_id',
        'item_id',
        'batch_number',
        'quantity',
        'expiry',
    ];

    protected $casts = [
        'quantity' => 'float',
        'expiry' => 'date',
    ];

    public function item()
    {
        return $this->belongsTo(InventoryItem::class, 'item_id');
    }
}
