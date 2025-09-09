<?php

namespace Modules\Reports\Contracts;

interface ReportGenerator
{
    /**
     * Generate report data for the module.
     *
     * @param array $filters
     * @return array
     */
    public function generate(array $filters): array;
}
