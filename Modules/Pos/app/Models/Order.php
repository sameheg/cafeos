<?php

namespace Modules\Pos\Models;

use App\Models\Tenant;
use App\Support\CurrencyFormatter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

class Order extends Model implements Auditable
{
    use HasFactory;
    use SoftDeletes;
    use AuditableTrait;

    protected static function booted(): void
    {
        static::addGlobalScope('tenant', function ($q): void {
            if (app()->bound('tenant')) {
                $q->where('tenant_id', tenant('id'));
            }
        });

        static::creating(function (self $order): void {
            if (app()->bound('tenant')) {
                $order->tenant_id ??= tenant('id');
            }
        });
    }

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
    ];

    protected $casts = [
        'split' => 'array',
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
}
