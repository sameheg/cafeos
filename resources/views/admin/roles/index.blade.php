@extends('layouts.app')

@section('content')
    <h1>Roles</h1>
    <a href="{{ route('admin.roles.create') }}">Create Role</a>
    <ul>
        @foreach($roles as $role)
            <li>{{ $role->name }}</li>
        @endforeach
    </ul>
@endsection
