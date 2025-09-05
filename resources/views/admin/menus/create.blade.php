@extends('layouts.app')

@section('content')
    <h1>Create Menu</h1>
    <form method="POST" action="{{ route('admin.menus.store') }}">
        @csrf
        <div>
            <label for="label">Label</label>
            <input type="text" id="label" name="label" value="{{ old('label') }}">
        </div>
        <div>
            <label for="url">URL</label>
            <input type="text" id="url" name="url" value="{{ old('url') }}">
        </div>
        <div>
            <label for="icon">Icon</label>
            <input type="text" id="icon" name="icon" value="{{ old('icon') }}">
        </div>
        <div>
            <label for="permission">Permission</label>
            <input type="text" id="permission" name="permission" value="{{ old('permission') }}">
        </div>
        <div>
            <label for="order">Order</label>
            <input type="number" id="order" name="order" value="{{ old('order') }}">
        </div>
        <button type="submit">Save</button>
    </form>
@endsection
