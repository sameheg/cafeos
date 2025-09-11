<?php

namespace Modules\Pos\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class PosOrder extends Model
{
    use HasUlids, SoftDeletes;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $table = 'pos_orders';

    protected $fillable = [
        'tenant_id',
        'table_id',
        'total',
        'status',
    ];

    protected $casts = [
        'id' => 'string',
        'tenant_id' => 'string',
        'table_id' => 'string',
    ];

    public const STATUS_OPEN = 'open';
    public const STATUS_PAID = 'paid';
    public const STATUS_CANCELLED = 'cancelled';

    public function items(): HasMany
    {
        return $this->hasMany(PosItem::class, 'order_id');
    }
}
