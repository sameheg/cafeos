@extends('layouts.app')

@section('content')
    <h1>Edit Permission</h1>
    <form method="POST" action="{{ route('admin.permissions.update', $permission) }}">
        @csrf
        @method('PUT')
        <div>
            <label for="name">Name</label>
            <input type="text" id="name" name="name" value="{{ old('name', $permission->name) }}">
        </div>
        <button type="submit">Update</button>
    </form>
@endsection

