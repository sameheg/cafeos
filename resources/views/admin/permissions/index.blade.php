@extends('layouts.app')

@section('content')
    <h1>Permissions</h1>
    <a href="{{ route('admin.permissions.create') }}">Create Permission</a>
    <ul>
        @foreach($permissions as $permission)
            <li>
                {{ $permission->name }}
                <a href="{{ route('admin.permissions.edit', $permission) }}">Edit</a>
                <form method="POST" action="{{ route('admin.permissions.destroy', $permission) }}" style="display:inline">
                <form action="{{ route('admin.permissions.destroy', $permission) }}" method="POST" style="display:inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Delete</button>
                </form>
            </li>
        @endforeach
    </ul>
@endsection
