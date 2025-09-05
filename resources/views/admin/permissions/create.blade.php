@extends('layouts.app')

@section('content')
    <h1>Create Permission</h1>
    <form method="POST" action="{{ route('admin.permissions.store') }}">
        @csrf
        <div>
            <label for="name">Name</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}">
        </div>
        <button type="submit">Save</button>
    </form>
@endsection
