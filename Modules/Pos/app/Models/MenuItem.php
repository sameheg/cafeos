<?php

namespace Modules\Pos\Models;

use App\Models\Tenant;
use App\Support\CurrencyFormatter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;
use App\Models\Concerns\BelongsToTenant;

class MenuItem extends Model implements Auditable
{
    use HasFactory;
    use SoftDeletes;
    use AuditableTrait;
    use BelongsToTenant;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'tenant_id',
        'name',
        'price',
    ];

    public function tenant(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function orders(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Order::class);
    }

    public function getFormattedPriceAttribute(): string
    {
        return CurrencyFormatter::format((float) $this->price);
    }

    public function toReportArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->formatted_price,
        ];
    }

    public function toExportArray(): array
    {
        return $this->toReportArray();
    }
}
