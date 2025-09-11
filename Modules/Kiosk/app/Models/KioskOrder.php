<?php

namespace Modules\Kiosk\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KioskOrder extends Model
{
    use HasUlids;

    protected $guarded = [];

    public function kiosk(): BelongsTo
    {
        return $this->belongsTo(Kiosk::class);
    }
}
