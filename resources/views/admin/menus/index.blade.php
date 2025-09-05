@extends('layouts.app')

@section('content')
    <h1>Menus</h1>
    <a href="{{ route('admin.menus.create') }}">Create Menu</a>
    <ul>
        @foreach($menus as $menu)
            <li>
                {{ $menu->label }} - {{ $menu->url }}
                <a href="{{ route('admin.menus.edit', $menu) }}">Edit</a>
                <form method="POST" action="{{ route('admin.menus.destroy', $menu) }}" style="display:inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Delete</button>
                </form>
            </li>
        @endforeach
    </ul>
@endsection
