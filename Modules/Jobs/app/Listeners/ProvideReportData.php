<?php

namespace Modules\Jobs\Listeners;

use Modules\Jobs\Services\JobsReportGenerator;
use Modules\Reports\Events\CollectReports;

class ProvideReportData
{
    public function __construct(private JobsReportGenerator $generator) {}

    public function handle(CollectReports $event): array
    {
        return $this->generator->generate($event->filters);
    }
}
