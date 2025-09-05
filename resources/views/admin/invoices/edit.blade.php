@extends('layouts.app')

@section('content')
    <h1>Edit Invoice Template</h1>
    <form method="POST" action="{{ route('admin.invoice-templates.update', $invoice_template) }}">
        @csrf
        @method('PUT')
        <div>
            <label>Name</label>
            <input type="text" name="name" value="{{ old('name', $invoice_template->name) }}">
        </div>
        <div>
            <label>Logo</label>
            <input type="text" name="logo" value="{{ old('logo', $invoice_template->logo) }}">
        </div>
        <div>
            <label>Header HTML</label>
            <textarea name="header_html">{{ old('header_html', $invoice_template->header_html) }}</textarea>
        </div>
        <div>
            <label>Footer HTML</label>
            <textarea name="footer_html">{{ old('footer_html', $invoice_template->footer_html) }}</textarea>
        </div>
        <div>
            <label>Field Toggles (JSON)</label>
            <textarea name="field_toggles">{{ old('field_toggles', $invoice_template->field_toggles) }}</textarea>
        </div>
        <button type="submit">Update</button>
    </form>
@endsection
