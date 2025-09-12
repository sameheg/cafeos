<?php

namespace Modules\Marketplace\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class MarketplaceBid extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = [
        'tenant_id',
        'rfq_id',
        'store_id',
        'price',
        'status',
    ];

    protected $casts = [
        'price' => 'float',
    ];

    public function store()
    {
        return $this->belongsTo(MarketplaceStore::class, 'store_id');
    }
}
