<?php

namespace Modules\EventManagement\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\EventManagement\Enums\TicketStatus;

class EventTicket extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';
    protected $table = 'event_tickets';

    protected $fillable = [
        'id',
        'tenant_id',
        'event_id',
        'attendee_id',
        'status',
    ];

    protected $casts = [
        'status' => TicketStatus::class,
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}
