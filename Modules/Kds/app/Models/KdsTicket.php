<?php

namespace Modules\Kds\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KdsTicket extends Model
{
    use HasFactory, HasUlids;

    protected $table = 'kds_tickets';

    protected $fillable = [
        'tenant_id',
        'order_id',
        'station',
        'status',
        'sla_time',
    ];

    protected $casts = [
        'sla_time' => 'datetime',
    ];

    public const STATUS_PENDING = 'pending';
    public const STATUS_INPROGRESS = 'inprogress';
    public const STATUS_COMPLETED = 'completed';

    protected $attributes = [
        'status' => self::STATUS_PENDING,
    ];

    public function scopeTenant($query, string $tenantId)
    {
        return $query->where('tenant_id', $tenantId);
    }

    public function bump(): void
    {
        $this->update(['status' => self::STATUS_COMPLETED]);
    }
}
