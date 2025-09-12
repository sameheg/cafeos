<?php

namespace Modules\Pos\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Modules\Pos\Models\PosOrder;

class BillingService
{
    public static function createInvoice(PosOrder $order): void
    {
        // Prefer Billing tables if present
        if (Schema::hasTable('billing_invoices')) {
            $id = DB::table('billing_invoices')->insertGetId([
                'tenant_id'=>$order->tenant_id,
                'order_id'=>$order->id,
                'customer_id'=>$order->customer_id,
                'currency'=>$order->currency,
                'subtotal'=>$order->subtotal,
                'tax'=>$order->tax_amount,
                'service'=>$order->service_amount,
                'discount'=>$order->discount_total,
                'total'=>$order->total,
                'status'=>'issued',
                'created_at'=>now(),'updated_at'=>now(),
            ]);
            // line items if table exists
            if (Schema::hasTable('billing_invoice_items')) {
                foreach ($order->items as $it) {
                    DB::table('billing_invoice_items')->insert([
                        'invoice_id'=>$id,
                        'name'=>$it->name,'qty'=>$it->qty,'price'=>$it->price,'total'=>$it->qty*$it->price,
                        'created_at'=>now(),'updated_at'=>now(),
                    ]);
                }
            }
            return;
        }
        // else: emit event (for external billing)
        event(new class($order){
            public function __construct(public PosOrder $order) {}
            public function __toString(){ return 'pos.billing.invoice.requested'; }
        });
    }
}
