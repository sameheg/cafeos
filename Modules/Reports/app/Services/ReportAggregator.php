<?php

namespace Modules\Reports\Services;

use Modules\Reports\Events\CollectReports;

class ReportAggregator
{
    /**
     * Aggregate report data from all modules.
     */
    public function aggregate(array $filters = []): array
    {
        $responses = event(new CollectReports($filters));

        return collect($responses)
            ->filter()
            ->flatten(1)
            ->all();
    }
}
