<?php

namespace Modules\Inventory\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Product;

class InventoryAlert extends Model
{
    protected $fillable = [
        'product_id',
        'type',
        'message',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
