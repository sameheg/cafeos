@extends('layouts.app')

@section('content')
    <h1>Create Invoice Template</h1>
    <form method="POST" action="{{ route('admin.invoice-templates.store') }}">
        @csrf
        <div>
            <label>Name</label>
            <input type="text" name="name" value="{{ old('name') }}">
        </div>
        <div>
            <label>Logo</label>
            <input type="text" name="logo" value="{{ old('logo') }}">
        </div>
        <div>
            <label>Header HTML</label>
            <textarea name="header_html">{{ old('header_html') }}</textarea>
        </div>
        <div>
            <label>Footer HTML</label>
            <textarea name="footer_html">{{ old('footer_html') }}</textarea>
        </div>
        <div>
            <label>Field Toggles (JSON)</label>
            <textarea name="field_toggles">{{ old('field_toggles') }}</textarea>
        </div>
        <button type="submit">Save</button>
    </form>
@endsection
