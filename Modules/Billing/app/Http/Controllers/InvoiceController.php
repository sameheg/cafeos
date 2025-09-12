<?php

namespace Modules\Billing\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Billing\Models\Invoice;
use Modules\Billing\Services\InvoiceCalculator;
use function Laravel\Pennant\feature;

class InvoiceController extends Controller
{
    public function store(Request $request)
    {
        $modules = $request->input('modules', []);
        $base = collect($modules)->sum('amount');
        $calculator = new InvoiceCalculator(feature('billing_proration')->active());
        $amount = $calculator->calculate($base, $request->input('proration_ratio', 1));

        $invoice = Invoice::create([
            'tenant_id' => $request->input('tenant_id'),
            'amount' => $amount,
            'status' => 'due',
            'due_date' => now()->addDays(30),
        ]);

        return response()->json(['invoice_id' => $invoice->id], 201);
    }

    public function history(string $tenantId)
    {
        $invoices = Invoice::where('tenant_id', $tenantId)->get();
        if ($invoices->isEmpty()) {
            return response()->json(['message' => 'Not Found'], 404);
        }

        return response()->json(['invoices' => $invoices]);
    }
}
