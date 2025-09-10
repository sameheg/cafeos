<?php

namespace Modules\Pos\Listeners;

use Modules\Pos\Services\PosReportGenerator;
use Modules\Reports\Events\CollectReports;

class ProvideReportData
{
    public function __construct(private PosReportGenerator $generator) {}

    public function handle(CollectReports $event): array
    {
        return $this->generator->generate($event->filters);
    }
}
