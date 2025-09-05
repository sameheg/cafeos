@extends('layouts.app')

@section('content')
    <h1>Edit Role</h1>
    <form method="POST" action="{{ route('admin.roles.update', $role) }}">
        @csrf
        @method('PUT')
        <div>
            <label for="name">Name</label>
            <input type="text" id="name" name="name" value="{{ old('name', $role->name) }}">
        </div>
        <div>
            <h3>Permissions</h3>
            @foreach($permissions as $permission)
                <div>
                    <label>
                        <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }}>
                        {{ $permission->name }}
                    </label>
                </div>
            @endforeach
        </div>
        <button type="submit">Update</button>
    </form>
@endsection
