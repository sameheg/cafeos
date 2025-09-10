<?php

namespace Modules\Marketplace\Listeners;

use Modules\Marketplace\Services\MarketplaceReportGenerator;
use Modules\Reports\Events\CollectReports;

class ProvideReportData
{
    public function __construct(private MarketplaceReportGenerator $generator) {}

    public function handle(CollectReports $event): array
    {
        return $this->generator->generate($event->filters);
    }
}
