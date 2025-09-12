<?php

namespace Modules\Procurement\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bid extends Model
{
    use HasFactory, HasUlids;

    protected $table = 'procurement_bids';

    protected $fillable = [
        'tenant_id',
        'rfq_id',
        'supplier_id',
        'price',
    ];

    public function rfq()
    {
        return $this->belongsTo(Rfq::class);
    }

    public function po()
    {
        return $this->hasOne(Po::class);
    }
}
