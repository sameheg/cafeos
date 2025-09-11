<?php

namespace Modules\Inventory\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class InventoryRecipe extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = [
        'tenant_id',
        'product_id',
        'ingredients',
    ];

    protected $casts = [
        'ingredients' => 'array',
    ];
}
