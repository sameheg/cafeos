<?php

namespace Modules\Reports\Events;

class CollectReports
{
    /**
     * Create a new event instance.
     */
    public function __construct(public array $filters = []) {}
}
