@extends('layouts.app')

@section('content')
    <h1>Permissions</h1>
    <a href="{{ route('admin.permissions.create') }}">Create Permission</a>
    <ul>
        @foreach($permissions as $permission)
            <li>{{ $permission->name }}</li>
        @endforeach
    </ul>
@endsection
