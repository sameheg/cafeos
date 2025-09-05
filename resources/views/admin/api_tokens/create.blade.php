@extends('layouts.app')

@section('content')
    <h1>Create API Token</h1>
    <form method="POST" action="{{ route('admin.api-tokens.store') }}">
        @csrf
        <label>Name</label>
        <input type="text" name="name" value="{{ old('name') }}">
        <label>Scopes (comma separated)</label>
        <input type="text" name="scopes" value="{{ old('scopes') }}">
        <label>Expires At</label>
        <input type="date" name="expires_at" value="{{ old('expires_at') }}">
        <button type="submit">Save</button>
    </form>
@endsection
