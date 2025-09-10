<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'shift_id',
        'clock_in',
        'clock_out',
    ];

    protected $casts = [
        'clock_in' => 'datetime',
        'clock_out' => 'datetime',
    ];

    protected $dispatchesEvents = [
        'saved' => \App\Events\AttendanceRecorded::class,
    ];

    public function shift(): BelongsTo
    {
        return $this->belongsTo(Shift::class);
    }

    public function getHoursWorkedAttribute(): float
    {
        if ($this->clock_in && $this->clock_out) {
            return $this->clock_out->diffInMinutes($this->clock_in) / 60;
        }

        return 0.0;
    }
}
