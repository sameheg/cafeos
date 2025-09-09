<?php

namespace Modules\Jobs\Listeners;

use Modules\Reports\Events\CollectReports;
use Modules\Jobs\Services\JobsReportGenerator;

class ProvideReportData
{
    public function __construct(private JobsReportGenerator $generator)
    {
    }

    public function handle(CollectReports $event): array
    {
        return $this->generator->generate($event->filters);
    }
}
