<?php

namespace Modules\Marketplace\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class MarketplaceStore extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = [
        'tenant_id',
        'supplier_id',
        'name',
        'tier',
    ];

    protected $casts = [
        'tier' => 'string',
    ];

    public function listings()
    {
        return $this->hasMany(MarketplaceListing::class, 'store_id');
    }

    public function bids()
    {
        return $this->hasMany(MarketplaceBid::class, 'store_id');
    }
}
