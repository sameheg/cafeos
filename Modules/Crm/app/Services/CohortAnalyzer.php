<?php

declare(strict_types=1);

namespace Modules\Crm\Services;

use Illuminate\Support\Collection;

class CohortAnalyzer
{
    /**
     * Split customers into equal cohorts for A/B testing.
     *
     * @param array<int, mixed> $customers
     * @return array<int, array<int, mixed>>
     */
    public function split(array $customers, int $cohorts = 2): array
    {
        $collection = collect($customers);
        $size = (int) ceil($collection->count() / $cohorts);
        return $collection->chunk($size)->toArray();
    }
}
