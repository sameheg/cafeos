<?php

namespace Modules\Kiosk\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kiosk extends Model
{
    use HasUlids;

    protected $guarded = [];

    public function orders(): HasMany
    {
        return $this->hasMany(KioskOrder::class);
    }
}
