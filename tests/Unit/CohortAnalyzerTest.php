<?php

declare(strict_types=1);

namespace Tests\Unit;

use Modules\Crm\Services\CohortAnalyzer;
use Tests\TestCase;

class CohortAnalyzerTest extends TestCase
{
    public function test_split_into_cohorts(): void
    {
        $analyzer = new CohortAnalyzer();
        $cohorts = $analyzer->split(range(1, 4), 2);
        $this->assertCount(2, $cohorts);
        $this->assertSame([1,2], $cohorts[0]);
    }
}
