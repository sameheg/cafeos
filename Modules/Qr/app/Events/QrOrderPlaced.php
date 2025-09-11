<?php

namespace Modules\Qr\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class QrOrderPlaced
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public string $orderId,
        public string $tableId
    ) {
    }

    public function toArray(): array
    {
        return [
            'order_id' => $this->orderId,
            'table_id' => $this->tableId,
        ];
    }
}
