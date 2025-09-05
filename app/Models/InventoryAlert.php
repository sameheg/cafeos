<?php

namespace App\Models;

use App\Business;
use App\Product;
use Illuminate\Database\Eloquent\Model;

class InventoryAlert extends Model
{
    protected $fillable = [
        'product_id',
        'business_id',
        'type',
        'message',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function business()
    {
        return $this->belongsTo(Business::class);
    }
}

