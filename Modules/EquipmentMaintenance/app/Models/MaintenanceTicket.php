<?php

namespace Modules\EquipmentMaintenance\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\EquipmentMaintenance\Enums\TicketStatus;
use Modules\EquipmentMaintenance\Events\TicketCreated;

class MaintenanceTicket extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = [
        'tenant_id',
        'equipment_id',
        'priority',
        'status',
    ];

    protected $casts = [
        'status' => TicketStatus::class,
    ];

    protected static function booted(): void
    {
        static::created(function (self $ticket): void {
            TicketCreated::dispatch($ticket->id, $ticket->equipment_id);
        });
    }

    public function start(): void
    {
        $this->update(['status' => TicketStatus::InProgress]);
    }

    public function finish(): void
    {
        $this->update(['status' => TicketStatus::Completed]);
    }

    public function delay(): void
    {
        $this->update(['status' => TicketStatus::Delayed]);
    }
}
