<?php

namespace Modules\HRJobs\Models;

use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\HRJobs\Events\ShiftCompleted;
use Modules\HRJobs\Services\PayrollCalculator;

class Shift extends Model
{
    use HasFactory, HasUlids;

    protected $table = 'hr_shifts';

    protected $fillable = ['tenant_id', 'employee_id', 'start', 'end', 'status'];

    protected $casts = [
        'start' => 'datetime',
        'end' => 'datetime',
    ];

    public const STATUS_SCHEDULED = 'scheduled';
    public const STATUS_ATTENDED = 'attended';
    public const STATUS_PAID = 'paid';
    public const STATUS_ABSENT = 'absent';

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    /**
     * Mark a shift as attended and emit the domain event.
     */
    public function checkin(): void
    {
        $this->update(['status' => self::STATUS_ATTENDED]);

        event(new ShiftCompleted($this));
    }

    /**
     * Generate payroll for the attended shift.
     */
    public function payroll(): void
    {
        $amount = app(PayrollCalculator::class)->calculate($this);

        Payroll::create([
            'tenant_id' => $this->tenant_id,
            'employee_id' => $this->employee_id,
            'period' => $this->start->copy()->startOfMonth(),
            'amount' => $amount,
        ]);

        $this->update(['status' => self::STATUS_PAID]);
    }

    /**
     * Scope to determine if a shift conflicts with existing ones.
     */
    public function scopeConflicts($query, string $employeeId, CarbonInterface $start, CarbonInterface $end)
    {
        return $query->where('employee_id', $employeeId)
            ->where(function ($q) use ($start, $end) {
                $q->whereBetween('start', [$start, $end])
                  ->orWhereBetween('end', [$start, $end])
                  ->orWhere(function ($q) use ($start, $end) {
                      $q->where('start', '<', $start)->where('end', '>', $end);
                  });
            });
    }
}

