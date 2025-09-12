<?php

namespace Modules\Marketplace\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class MarketplaceListing extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = [
        'tenant_id',
        'store_id',
        'item_id',
        'price',
        'stock',
    ];

    protected $casts = [
        'price' => 'float',
        'stock' => 'integer',
    ];

    public function store()
    {
        return $this->belongsTo(MarketplaceStore::class, 'store_id');
    }
}
