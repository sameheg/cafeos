@extends('layouts.app')

@section('content')
    <h1>{{ $file }}</h1>

    <form method="GET" action="{{ route('admin.logs.show', $file) }}">
        <input type="text" name="q" value="{{ $query }}" placeholder="Search">
        <button type="submit">Search</button>
    </form>

    <a href="{{ route('admin.logs.show', $file) }}?download=1">Download</a>

    <pre>
@foreach($logs as $line)
{{ $line }}
@endforeach
    </pre>

    {{ $logs->withQueryString()->links() }}
@endsection
