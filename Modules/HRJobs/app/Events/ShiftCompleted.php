<?php

namespace Modules\HRJobs\Events;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Modules\HRJobs\Models\Shift;

class ShiftCompleted
{
    use Dispatchable, SerializesModels;

    public function __construct(public Shift $shift)
    {
    }

    /**
     * JSON representation for domain event bus.
     */
    public function toDomain(): array
    {
        return [
            'event' => 'hr.shift.completed@v1',
            'data' => [
                'shift_id' => $this->shift->id,
                'employee_id' => $this->shift->employee_id,
            ],
        ];
    }
}

