@extends('layouts.app')

@section('content')
    <h1>Create Role</h1>
    <form method="POST" action="{{ route('admin.roles.store') }}">
        @csrf
        <div>
            <label for="name">Name</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}">
        </div>
        <div>
            <h3>Permissions</h3>
            @foreach($permissions as $permission)
                <div>
                    <label>
                        <input type="checkbox" name="permissions[]" value="{{ $permission->id }}">
                        {{ $permission->name }}
                    </label>
                </div>
            @endforeach
        </div>
        <button type="submit">Save</button>
    </form>
@endsection
