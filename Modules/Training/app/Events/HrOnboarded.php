<?php

namespace Modules\Training\Events;

class HrOnboarded
{
    public function __construct(
        public string $employeeId,
        public string $tenantId
    ) {
    }
}
