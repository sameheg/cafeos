<?php

namespace Modules\HRJobs\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Crypt;

class Payroll extends Model
{
    use HasFactory, HasUlids;

    protected $table = 'hr_payrolls';

    protected $fillable = ['tenant_id', 'employee_id', 'period', 'amount'];

    protected $casts = [
        'period' => 'date',
        'id' => 'string',
    ];

    public function setAmountAttribute($value): void
    {
        $this->attributes['amount'] = Crypt::encryptString((string) $value);
    }

    public function getAmountAttribute($value): float
    {
        return (float) Crypt::decryptString($value);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}

