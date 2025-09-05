@extends('layouts.app')

@section('content')
    <h1>Invoice Templates</h1>
    <a href="{{ route('admin.invoice-templates.create') }}">Create Template</a>
    <ul>
        @foreach($templates as $template)
            <li>
                {{ $template->name }}
                <a href="{{ route('admin.invoice-templates.edit', $template) }}">Edit</a>
                <form method="POST" action="{{ route('admin.invoice-templates.destroy', $template) }}" style="display:inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Delete</button>
                </form>
            </li>
        @endforeach
    </ul>
@endsection
