<?php

namespace Modules\EventManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';
    protected $table = 'events';

    protected $fillable = [
        'id',
        'tenant_id',
        'name',
        'capacity',
    ];

    public function tickets(): HasMany
    {
        return $this->hasMany(EventTicket::class);
    }
}
