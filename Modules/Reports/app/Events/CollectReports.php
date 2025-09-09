<?php

namespace Modules\Reports\Events;

class CollectReports
{
    /**
     * Create a new event instance.
     *
     * @param array $filters
     */
    public function __construct(public array $filters = [])
    {
    }
}
