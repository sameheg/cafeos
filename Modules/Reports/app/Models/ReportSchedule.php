<?php

namespace Modules\Reports\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportSchedule extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = [
        'tenant_id',
        'report_id',
        'frequency',
    ];

    protected static function newFactory()
    {
        return \Modules\Reports\Database\Factories\ReportScheduleFactory::new();
    }
}
