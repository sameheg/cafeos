<?php
namespace Modules\Pos\App\Contracts;

use Modules\Pos\App\Models\Order;

interface BillingGateway {
    public function createInvoice(Order $order, array $lines, array $meta = []): array; // returns ['invoice_id'=>..., 'number'=>..., 'total'=>...]
}
