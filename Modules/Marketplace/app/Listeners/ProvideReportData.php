<?php

namespace Modules\Marketplace\Listeners;

use Modules\Reports\Events\CollectReports;
use Modules\Marketplace\Services\MarketplaceReportGenerator;

class ProvideReportData
{
    public function __construct(private MarketplaceReportGenerator $generator)
    {
    }

    public function handle(CollectReports $event): array
    {
        return $this->generator->generate($event->filters);
    }
}
