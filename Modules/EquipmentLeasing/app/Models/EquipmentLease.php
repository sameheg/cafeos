<?php

namespace Modules\EquipmentLeasing\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EquipmentLease extends Model
{
    protected $table = 'equipment_leases';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'tenant_id',
        'equipment_id',
        'end_date',
        'status',
    ];

    protected $casts = [
        'end_date' => 'date',
    ];

    public function listing(): BelongsTo
    {
        return $this->belongsTo(EquipmentListing::class, 'equipment_id');
    }

    public function pay(): void
    {
        $this->update(['status' => 'paid']);
    }

    public function reportDamage(): void
    {
        $this->update(['status' => 'damaged']);
    }

    public function repair(): void
    {
        $this->update(['status' => 'repaired']);
    }
}

