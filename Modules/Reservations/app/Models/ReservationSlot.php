<?php

namespace Modules\Reservations\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Models\Traits\BelongsToTenant;

class ReservationSlot extends Model
{
    use HasFactory, HasUlids, BelongsToTenant;

    public $timestamps = false;

    protected $fillable = [
        'tenant_id',
        'date',
        'capacity',
    ];

    protected $casts = [
        'date' => 'date',
    ];
}
