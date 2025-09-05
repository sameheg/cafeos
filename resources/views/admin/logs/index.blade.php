@extends('layouts.app')

@section('content')
    <h1>Logs</h1>
    <ul>
        @foreach($files as $file)
            <li>
                <a href="{{ route('admin.logs.show', $file) }}">{{ $file }}</a>
                <a href="{{ route('admin.logs.show', $file) }}?download=1">Download</a>
            </li>
        @endforeach
    </ul>
@endsection
