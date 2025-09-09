<?php

namespace Modules\Crm\Listeners;

use Modules\Reports\Events\CollectReports;
use Modules\Crm\Services\CrmReportGenerator;

class ProvideReportData
{
    public function __construct(private CrmReportGenerator $generator)
    {
    }

    public function handle(CollectReports $event): array
    {
        return $this->generator->generate($event->filters);
    }
}
