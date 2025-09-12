<?php

namespace Modules\Procurement\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rfq extends Model
{
    use HasFactory, HasUlids;

    protected $table = 'procurement_rfqs';

    protected $fillable = [
        'tenant_id',
        'items',
        'status',
    ];

    protected $casts = [
        'items' => 'array',
    ];

    public function bids()
    {
        return $this->hasMany(Bid::class);
    }
}
