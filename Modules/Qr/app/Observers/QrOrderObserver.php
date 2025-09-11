<?php

namespace Modules\Qr\Observers;

use Modules\Qr\Events\QrOrderPlaced;
use Modules\Qr\Models\QrOrder;

class QrOrderObserver
{
    public function created(QrOrder $order): void
    {
        $tableId = $order->qrCode()->value('table_id');
        event(new QrOrderPlaced($order->id, (string) $tableId));
    }
}
