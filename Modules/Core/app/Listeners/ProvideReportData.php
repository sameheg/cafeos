<?php

namespace Modules\Core\Listeners;

use Modules\Core\Services\CoreReportGenerator;
use Modules\Reports\Events\CollectReports;

class ProvideReportData
{
    public function __construct(private CoreReportGenerator $generator) {}

    public function handle(CollectReports $event): array
    {
        return $this->generator->generate($event->filters);
    }
}
