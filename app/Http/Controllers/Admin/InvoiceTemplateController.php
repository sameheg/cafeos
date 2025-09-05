<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\InvoiceTemplate;
use Illuminate\Http\Request;

class InvoiceTemplateController extends Controller
{
    public function index()
    {
        $templates = InvoiceTemplate::all();
        return view('admin.invoices.index', compact('templates'));
    }

    public function create()
    {
        return view('admin.invoices.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'logo' => 'nullable|string',
            'header_html' => 'nullable|string',
            'footer_html' => 'nullable|string',
            'field_toggles' => 'nullable|string',
        ]);

        $data['business_id'] = $request->session()->get('user.business_id');
        if (! empty($data['field_toggles'])) {
            $data['field_toggles'] = json_decode($data['field_toggles'], true);
        }

        InvoiceTemplate::create($data);

        return redirect()->route('admin.invoice-templates.index');
    }

    public function edit(InvoiceTemplate $invoice_template)
    {
        $invoice_template->field_toggles = ! empty($invoice_template->field_toggles)
            ? json_encode($invoice_template->field_toggles)
            : null;
        return view('admin.invoices.edit', compact('invoice_template'));
    }

    public function update(Request $request, InvoiceTemplate $invoice_template)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'logo' => 'nullable|string',
            'header_html' => 'nullable|string',
            'footer_html' => 'nullable|string',
            'field_toggles' => 'nullable|string',
        ]);

        if (! empty($data['field_toggles'])) {
            $data['field_toggles'] = json_decode($data['field_toggles'], true);
        }

        $invoice_template->update($data);

        return redirect()->route('admin.invoice-templates.index');
    }

    public function destroy(InvoiceTemplate $invoice_template)
    {
        $invoice_template->delete();
        return redirect()->route('admin.invoice-templates.index');
    }
}
