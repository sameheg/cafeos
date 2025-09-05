@extends('layouts.app')

@section('content')
    <h1>Roles</h1>
    <a href="{{ route('admin.roles.create') }}">Create Role</a>
    <ul>
        @foreach($roles as $role)
            <li>
                {{ $role->name }}
                <a href="{{ route('admin.roles.edit', $role) }}">Edit</a>
                <form action="{{ route('admin.roles.destroy', $role) }}" method="POST" style="display:inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Delete</button>
                </form>
            </li>
        @endforeach
    </ul>
@endsection
