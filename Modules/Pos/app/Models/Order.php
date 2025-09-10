<?php

namespace Modules\Pos\Models;

use App\Models\Tenant;
use App\Models\TenantModel;
use App\Support\CurrencyFormatter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Pos\Events\OrderCacheInvalidated;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

class Order extends TenantModel implements Auditable
{
    use AuditableTrait;
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'tenant_id',
        'total',
        'status',
        'is_debt',
        'table_id',
        'split',
        'order_type',
        'queue_number',
    ];

    protected $casts = [
        'split' => 'array',
    ];

    protected array $preload = ['menuItems'];

    protected $dispatchesEvents = [
        'created' => OrderCacheInvalidated::class,
        'updated' => OrderCacheInvalidated::class,
        'deleted' => OrderCacheInvalidated::class,
    ];

    public function tenant(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function menuItems(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(MenuItem::class);
    }

    public function getFormattedTotalAttribute(): string
    {
        return CurrencyFormatter::format((float) $this->total);
    }

    public function toReportArray(): array
    {
        return [
            'id' => $this->id,
            'total' => $this->formatted_total,
            'status' => $this->status,
        ];
    }

    public function toExportArray(): array
    {
        return $this->toReportArray();
    }

    protected static function newFactory(): \Modules\Pos\Database\Factories\OrderFactory
    {
        return \Modules\Pos\Database\Factories\OrderFactory::new();
    }
}
