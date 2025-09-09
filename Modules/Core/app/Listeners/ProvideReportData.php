<?php

namespace Modules\Core\Listeners;

use Modules\Reports\Events\CollectReports;
use Modules\Core\Services\CoreReportGenerator;

class ProvideReportData
{
    public function __construct(private CoreReportGenerator $generator)
    {
    }

    public function handle(CollectReports $event): array
    {
        return $this->generator->generate($event->filters);
    }
}
