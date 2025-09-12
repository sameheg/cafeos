<?php

namespace Modules\HotelPms\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

class Folio extends Model
{
    use HasUlids;

    public $incrementing = false;
    protected $keyType = 'string';
    protected $table = 'pms_folios';

    protected $fillable = [
        'tenant_id',
        'guest_id',
        'total',
        'status',
    ];

    protected $casts = [
        'id' => 'string',
        'tenant_id' => 'string',
        'total' => 'decimal:2',
    ];

    public const STATUS_OPEN = 'open';
    public const STATUS_POSTED = 'posted';

    public function post(float $amount): void
    {
        $this->total = $amount;
        $this->status = self::STATUS_POSTED;
        $this->save();
    }
}
