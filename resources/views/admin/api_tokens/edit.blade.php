@extends('layouts.app')

@section('content')
    <h1>Edit API Token</h1>
    <form method="POST" action="{{ route('admin.api-tokens.update', $api_token) }}">
        @csrf
        @method('PUT')
        <label>Name</label>
        <input type="text" name="name" value="{{ old('name', $api_token->name) }}">
        <label>Scopes (comma separated)</label>
        <input type="text" name="scopes" value="{{ old('scopes', $api_token->scopes) }}">
        <label>Expires At</label>
        <input type="date" name="expires_at" value="{{ old('expires_at', optional($api_token->expires_at)->toDateString()) }}">
        <button type="submit">Update</button>
    </form>
@endsection
