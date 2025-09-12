<?php

namespace Modules\Reports\Models;

use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Event;
use Modules\Reports\Events\ReportGenerated;
use Modules\Reports\Exports\ReportExport;
use Maatwebsite\Excel\Facades\Excel;

class Report extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = [
        'tenant_id',
        'type',
        'data',
        'generated_at',
    ];

    protected $casts = [
        'data' => AsArrayObject::class,
        'generated_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::created(function (self $report): void {
            Event::dispatch(new ReportGenerated($report));
        });
    }

    protected static function newFactory()
    {
        return \Modules\Reports\Database\Factories\ReportFactory::new();
    }

    public function export(string $format = 'xlsx')
    {
        if ($format === 'xlsx') {
            return Excel::download(new ReportExport($this), $this->id.'.xlsx');
        }

        throw new \InvalidArgumentException('Unsupported format');
    }
}
