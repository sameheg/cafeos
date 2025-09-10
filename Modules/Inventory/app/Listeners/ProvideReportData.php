<?php

namespace Modules\Inventory\Listeners;

use Modules\Inventory\Services\InventoryReportGenerator;
use Modules\Reports\Events\CollectReports;

class ProvideReportData
{
    public function __construct(private InventoryReportGenerator $generator) {}

    public function handle(CollectReports $event): array
    {
        return $this->generator->generate($event->filters);
    }
}
