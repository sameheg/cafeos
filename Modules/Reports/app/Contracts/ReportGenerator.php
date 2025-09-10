<?php

namespace Modules\Reports\Contracts;

interface ReportGenerator
{
    /**
     * Generate report data for the module.
     */
    public function generate(array $filters): array;
}
