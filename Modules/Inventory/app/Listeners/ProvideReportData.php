<?php

namespace Modules\Inventory\Listeners;

use Modules\Reports\Events\CollectReports;
use Modules\Inventory\Services\InventoryReportGenerator;

class ProvideReportData
{
    public function __construct(private InventoryReportGenerator $generator)
    {
    }

    public function handle(CollectReports $event): array
    {
        return $this->generator->generate($event->filters);
    }
}
