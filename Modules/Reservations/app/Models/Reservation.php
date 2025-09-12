<?php

namespace Modules\Reservations\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Models\Traits\BelongsToTenant;

class Reservation extends Model
{
    use HasFactory, HasUlids, BelongsToTenant;

    protected $fillable = [
        'tenant_id',
        'table_id',
        'time',
        'status',
    ];

    protected $casts = [
        'time' => 'datetime',
        'status' => ReservationStatus::class,
    ];
}
