<?php

namespace Modules\Kds\Models;

use App\Models\TenantModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KitchenTicket extends TenantModel
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'order_id',
        'station_id',
        'status',
        'approved',
    ];

    public function order()
    {
        return $this->belongsTo(\Modules\Pos\Models\Order::class);
    }

    public function station()
    {
        return $this->belongsTo(KitchenStation::class);
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'yellow',
            'cooking' => 'orange',
            'ready' => 'green',
            default => 'gray',
        };
    }
}
