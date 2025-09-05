<?php

namespace App\Listeners;

use App\Events\TableOrderPlaced;
use Modules\POS\Services\OrderService;

class SendTableOrderToPos
{
    protected OrderService $orders;

    public function __construct(OrderService $orders)
    {
        $this->orders = $orders;
    }

    public function handle(TableOrderPlaced $event): void
    {
        $this->orders->processTableOrder($event->tableOrder);
    }
}
