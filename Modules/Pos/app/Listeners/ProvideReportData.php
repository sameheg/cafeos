<?php

namespace Modules\Pos\Listeners;

use Modules\Reports\Events\CollectReports;
use Modules\Pos\Services\PosReportGenerator;

class ProvideReportData
{
    public function __construct(private PosReportGenerator $generator)
    {
    }

    public function handle(CollectReports $event): array
    {
        return $this->generator->generate($event->filters);
    }
}
