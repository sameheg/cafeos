<?php

namespace Modules\Kds\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KitchenTicket extends Model
{
    use HasFactory;

    protected $fillable = [
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
