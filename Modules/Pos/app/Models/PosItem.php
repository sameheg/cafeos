<?php

namespace Modules\Pos\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PosItem extends Model
{
    use HasUlids;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $table = 'pos_items';

    protected $fillable = [
        'order_id',
        'product_id',
        'qty',
        'price',
    ];

    protected $casts = [
        'id' => 'string',
        'order_id' => 'string',
        'product_id' => 'string',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(PosOrder::class, 'order_id');
    }
}
