<?php

namespace Modules\Inventory\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class InventoryItem extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = [
        'tenant_id',
        'name',
        'quantity',
        'unit',
        'reorder_level',
    ];

    protected $casts = [
        'quantity' => 'float',
        'reorder_level' => 'float',
    ];

    public function batches()
    {
        return $this->hasMany(InventoryBatch::class, 'item_id');
    }
}
